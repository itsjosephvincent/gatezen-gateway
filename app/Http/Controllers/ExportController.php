<?php

namespace App\Http\Controllers;

use App\Exports\ExportDealEntries;
use App\Exports\ExportInvoices;
use App\Exports\ExportSegmentUsers;
use App\Exports\ExportUsers;
use App\Interface\Repositories\DealRepositoryInterface;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    private $dealRepository;

    public function __construct(DealRepositoryInterface $dealRepository)
    {
        $this->dealRepository = $dealRepository;
    }

    public function exportDealEntries()
    {
        $request = request('deal_id');

        $deal = $this->dealRepository->findDealById($request);

        return Excel::download(new ExportDealEntries($request), $deal->name.' - '.now()->format('d-m-Y').'.xlsx');
    }

    public function exportInvoices()
    {
        return Excel::download(new ExportInvoices(), 'Invoices - '.now()->format('d-m-Y').'.xlsx');
    }

    public function exportUsers()
    {
        return Excel::download(new ExportUsers(), 'Users - '.now()->format('d-m-Y').'.xlsx');
    }

    public function exportSegmentUsers()
    {
        return Excel::download(new ExportSegmentUsers(), 'Segment Users - '.now()->format('d-m-Y').'.xlsx');
    }
}
