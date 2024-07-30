<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\KycDocumentController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::group([
    'middleware' => 'auth',
    'prefix' => 'user',
], function ($router): void {
    Route::get('/download-portfolio/{user}', [PdfController::class, 'downloadPortfolio'])->name('pdf.portfolio');
    Route::get('/download-invoice/{invoice}', [PdfController::class, 'downloadInvoice'])->name('pdf.invoice');
    Route::get('/download/{kycDocumentId}/document', [KycDocumentController::class, 'download'])->name('kyc.download');
    Route::get('/send-portfolio/{user}', [PdfController::class, 'sendPdf'])->name('pdf.send-portfolio');
    Route::get('/send-invoice/{invoice}', [PdfController::class, 'sendInvoice'])->name('pdf.send-invoice');
    Route::get('/export-deal-entries', [ExportController::class, 'exportDealEntries']);
    Route::get('/export-invoices', [ExportController::class, 'exportInvoices']);
    Route::get('/export-users', [ExportController::class, 'exportUsers']);
    Route::get('/export-segment-users', [ExportController::class, 'exportSegmentUsers']);
    Route::post('/import', [UserController::class, 'import'])->name('user.import');
});
