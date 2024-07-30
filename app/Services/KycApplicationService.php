<?php

namespace App\Services;

use App\Enum\KycApplicationStatus;
use App\Enum\KycDocumentStatus;
use App\Exceptions\KycDocument\DocumentExistException;
use App\Http\Resources\KycApplicationResource;
use App\Interface\Repositories\DocumentTypeRepositoryInterface;
use App\Interface\Repositories\NotificationRepositoryInterface;
use App\Repositories\KycApplicationRepository;
use App\Repositories\KycDocumentRepository;
use App\Repositories\KycRequiredDocRepository;
use Illuminate\Support\Facades\DB;

class KycApplicationService
{
    private $kycApplicationRepository;

    private $kycDocumentRepository;

    private $documentTypeRepository;

    private $kycRequiredDocRepository;

    private $notificationRepository;

    public function __construct(
        KycApplicationRepository $kycApplicationRepository,
        KycDocumentRepository $kycDocumentRepository,
        DocumentTypeRepositoryInterface $documentTypeRepository,
        KycRequiredDocRepository $kycRequiredDocRepository,
        NotificationRepositoryInterface $notificationRepository
    ) {
        $this->kycApplicationRepository = $kycApplicationRepository;
        $this->kycDocumentRepository = $kycDocumentRepository;
        $this->documentTypeRepository = $documentTypeRepository;
        $this->kycRequiredDocRepository = $kycRequiredDocRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function storeApplication($payload, $user)
    {
        DB::beginTransaction();
        $kycApplication = $this->kycApplicationRepository->findKycApplicationByUserId($user->id);
        $docType = $this->documentTypeRepository->findDocumentTypeById($payload->document_type_id);
        if ($docType) {
            $kycDoc = $this->kycDocumentRepository->findKycDocumentByUserIdAndDocType($payload, $user->id);

            if ($kycDoc) {
                throw new DocumentExistException();
            }

            $kycDocument = $this->kycDocumentRepository->createKycDocument($kycApplication->id, $docType->id);
            $this->kycDocumentRepository->insertMedia($payload, $kycDocument->id);
            DB::commit();

            $newKyc = $this->kycApplicationRepository->findKycApplicationByUserId($user->id);

            return new KycApplicationResource($newKyc);
        }
        DB::rollBack();
    }

    public function getKycApplication($user)
    {
        $kycApplication = $this->kycApplicationRepository->findKycApplicationByUserId($user->id);
        $docIds = $this->documentTypeRepository->findIdAndAddress();

        if (! $kycApplication) {
            $application = $this->kycApplicationRepository->createKycApplication($user);

            foreach ($docIds as $docId) {
                $this->kycRequiredDocRepository->createKycRequiredDocs($docId, $application->id);
            }

            $newKycApplication = $this->kycApplicationRepository->findKycApplicationByUserId($user->id);

            return new KycApplicationResource($newKycApplication);
        }

        return new KycApplicationResource($kycApplication);
    }

    public function processKycStatus($data, $record)
    {
        $status = [
            KycDocumentStatus::Waiting->value,
            KycDocumentStatus::Pending->value,
        ];

        $docStatus = $this->kycDocumentRepository->findUserKycDocumentStatuses($record->id);

        $checkStatus = array_diff(json_decode($docStatus, true), $status);

        if ($data['application_status'] === KycApplicationStatus::Approved->value) {
            if (empty($checkStatus)) {
                return $this->notificationRepository->showNotification('Failed', 'All documents from this application is not yet approved.', 'warning');
            }
            $this->kycApplicationRepository->updateKycStatus($data, $record->user_id);
        }

        $this->kycApplicationRepository->updateKycStatus($data, $record->user_id);

        return $this->notificationRepository->showNotification('Success', 'Status has been successfully updated!', 'success');
    }

    public function processKycInternalNoteReference($data, $userId)
    {
        $this->kycApplicationRepository->updateKycInternalNoteReference($data, $userId);

        return $this->notificationRepository->showNotification('Success', 'Internal Note/Reference has been successfully updated!', 'success');
    }
}
