<?php

namespace App\Services;

use App\Enum\KycDocumentStatus;
use App\Events\KycEvent;
use App\Interface\Repositories\NotificationRepositoryInterface;
use App\Mail\SendRejectedKycEmail;
use App\Repositories\KycApplicationRepository;
use App\Repositories\KycDocumentRepository;
use Illuminate\Support\Facades\Mail;

class KycDocumentService
{
    private $kycDocumentRepository;

    private $notificationRepository;

    private $kycApplicationRepository;

    public function __construct(
        KycDocumentRepository $kycDocumentRepository,
        NotificationRepositoryInterface $notificationRepository,
        KycApplicationRepository $kycApplicationRepository
    ) {
        $this->kycDocumentRepository = $kycDocumentRepository;
        $this->notificationRepository = $notificationRepository;
        $this->kycApplicationRepository = $kycApplicationRepository;
    }

    public function updateKycDocument(array $data, $record)
    {
        $document = $this->kycDocumentRepository->update($data, $record);
        $application = $this->kycApplicationRepository->findById($record->kyc_application_id);
        if ($document->status === KycDocumentStatus::Rejected->value) {
            Mail::to($application->user->email)
                ->send(new SendRejectedKycEmail($document));

            event(new KycEvent($application));

            return $this->notificationRepository->showNotification('Update success', 'An email notification has been sent to the user.', 'success');
        }

        event(new KycEvent($application));

        return $this->notificationRepository->showNotification('Update success', 'KYC document successfully updated.', 'success');
    }

    public function downloadKycDocument($kycDocumentId)
    {
        $document = $this->kycDocumentRepository->download($kycDocumentId);

        if (! $document) {
            return $this->notificationRepository->showNotification('Download failed', 'You do not have the permission to download this document', 'warning');
        }

        return $document;
    }

    public function deleteDocument($kycDocumentId)
    {
        $this->kycDocumentRepository->deleteDocumentById($kycDocumentId);

        return $this->notificationRepository->showNotification('Success', 'The document has been successfully deleted.', 'success');
    }
}
