<?php

namespace App\Providers;

use App\Interface\Repositories\AddressRepositoryInterface;
use App\Interface\Repositories\AuditRepositoryInterface;
use App\Interface\Repositories\CountryRepositoryInterface;
use App\Interface\Repositories\CurrencyRepositoryInterface;
use App\Interface\Repositories\DealEntryRepositoryInterface;
use App\Interface\Repositories\DealRepositoryInterface;
use App\Interface\Repositories\DocumentTypeRepositoryInterface;
use App\Interface\Repositories\EntityRepositoryInterface;
use App\Interface\Repositories\ExternalDataRepositoryInterface;
use App\Interface\Repositories\ExternalDataTypeRepositoryInterface;
use App\Interface\Repositories\InvoicePaymentRepositoryInterface;
use App\Interface\Repositories\InvoiceProductRepositoryInterface;
use App\Interface\Repositories\InvoiceRepositoryInterface;
use App\Interface\Repositories\LanguageRepositoryInterface;
use App\Interface\Repositories\NotificationRepositoryInterface;
use App\Interface\Repositories\PasswordResetRepositoryInterface;
use App\Interface\Repositories\PdfTemplateRepositoryInterface;
use App\Interface\Repositories\ProjectRepositoryInterface;
use App\Interface\Repositories\ProjectSyncRepositoryInterface;
use App\Interface\Repositories\SalesOrderProductRepositoryInterface;
use App\Interface\Repositories\SalesOrderRepositoryInterface;
use App\Interface\Repositories\SyncRepositoryInterface;
use App\Interface\Repositories\TickerRepositoryInterface;
use App\Interface\Repositories\TransactionRepositoryInterface;
use App\Interface\Repositories\UserRepositoryInterface;
use App\Interface\Repositories\WalletRepositoryInterface;
use App\Interface\Repositories\ZohoRepositoryInterface;
use App\Interface\Services\AddressServiceInterface;
use App\Interface\Services\AuthServiceInterface;
use App\Interface\Services\CountryServiceInterface;
use App\Interface\Services\DealEntryServiceInterface;
use App\Interface\Services\DealServiceInterface;
use App\Interface\Services\ExchangeServiceInterface;
use App\Interface\Services\InvoiceServiceInterface;
use App\Interface\Services\LanguageServiceInterface;
use App\Interface\Services\NotificationServiceInterface;
use App\Interface\Services\ProjectServiceInterface;
use App\Interface\Services\SalesOrderProductServiceInterface;
use App\Interface\Services\SalesOrderServiceInterface;
use App\Interface\Services\TickerServiceInterface;
use App\Interface\Services\TransactionServiceInterface;
use App\Interface\Services\UserServiceInterface;
use App\Interface\Services\WalletServiceInterface;
use App\Repositories\AddressRepository;
use App\Repositories\AuditRepository;
use App\Repositories\CountryRepository;
use App\Repositories\CurrencyRepository;
use App\Repositories\DealEntryRepository;
use App\Repositories\DealRepository;
use App\Repositories\DocumentTypeRepository;
use App\Repositories\EntityRepository;
use App\Repositories\ExternalDataRepository;
use App\Repositories\ExternalDataTypeRepository;
use App\Repositories\InvoicePaymentRepository;
use App\Repositories\InvoiceProductRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\PasswordResetRepository;
use App\Repositories\PdfTemplateRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\ProjectSyncRepository;
use App\Repositories\SalesOrderProductRepository;
use App\Repositories\SalesOrderRepository;
use App\Repositories\SyncRepository;
use App\Repositories\TickerRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use App\Repositories\ZohoRepository;
use App\Services\AddressService;
use App\Services\AuthService;
use App\Services\CountryService;
use App\Services\DealEntryService;
use App\Services\DealService;
use App\Services\ExchangeService;
use App\Services\InvoiceService;
use App\Services\LanguageService;
use App\Services\NotificationService;
use App\Services\ProjectService;
use App\Services\SalesOrderProductService;
use App\Services\SalesOrderService;
use App\Services\TickerService;
use App\Services\TransactionService;
use App\Services\UserService;
use App\Services\WalletService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //repositories
        $this->app->bind(DealEntryRepositoryInterface::class, DealEntryRepository::class);
        $this->app->bind(DealRepositoryInterface::class, DealRepository::class);
        $this->app->bind(DocumentTypeRepositoryInterface::class, DocumentTypeRepository::class);
        $this->app->bind(InvoiceProductRepositoryInterface::class, InvoiceProductRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(PasswordResetRepositoryInterface::class, PasswordResetRepository::class);
        $this->app->bind(PdfTemplateRepositoryInterface::class, PdfTemplateRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(SalesOrderProductRepositoryInterface::class, SalesOrderProductRepository::class);
        $this->app->bind(SalesOrderRepositoryInterface::class, SalesOrderRepository::class);
        $this->app->bind(TickerRepositoryInterface::class, TickerRepository::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(WalletRepositoryInterface::class, WalletRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
        $this->app->bind(LanguageRepositoryInterface::class, LanguageRepository::class);
        $this->app->bind(ProjectSyncRepositoryInterface::class, ProjectSyncRepository::class);
        $this->app->bind(SyncRepositoryInterface::class, SyncRepository::class);
        $this->app->bind(ExternalDataTypeRepositoryInterface::class, ExternalDataTypeRepository::class);
        $this->app->bind(ExternalDataRepositoryInterface::class, ExternalDataRepository::class);
        $this->app->bind(ZohoRepositoryInterface::class, ZohoRepository::class);
        $this->app->bind(CurrencyRepositoryInterface::class, CurrencyRepository::class);
        $this->app->bind(InvoicePaymentRepositoryInterface::class, InvoicePaymentRepository::class);
        $this->app->bind(EntityRepositoryInterface::class, EntityRepository::class);
        $this->app->bind(AuditRepositoryInterface::class, AuditRepository::class);

        //services
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(DealServiceInterface::class, DealService::class);
        $this->app->bind(ExchangeServiceInterface::class, ExchangeService::class);
        $this->app->bind(InvoiceServiceInterface::class, InvoiceService::class);
        $this->app->bind(NotificationServiceInterface::class, NotificationService::class);
        $this->app->bind(ProjectServiceInterface::class, ProjectService::class);
        $this->app->bind(SalesOrderServiceInterface::class, SalesOrderService::class);
        $this->app->bind(TickerServiceInterface::class, TickerService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(WalletServiceInterface::class, WalletService::class);
        $this->app->bind(CountryServiceInterface::class, CountryService::class);
        $this->app->bind(AddressServiceInterface::class, AddressService::class);
        $this->app->bind(LanguageServiceInterface::class, LanguageService::class);
        $this->app->bind(TransactionServiceInterface::class, TransactionService::class);
        $this->app->bind(SalesOrderProductServiceInterface::class, SalesOrderProductService::class);
        $this->app->bind(DealEntryServiceInterface::class, DealEntryService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
