<?php

namespace App\Repositories;

use App\Enum\Connection;
use App\Enum\Status;
use App\Enum\WalletType;
use App\Interface\Repositories\ProjectSyncRepositoryInterface;
use App\Models\EntityType;
use App\Models\Ticker;
use App\Services\ExchangeService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDO;
use Spatie\Permission\Models\Role;
use Throwable;

class ProjectSyncRepository implements ProjectSyncRepositoryInterface
{
    private $projectRepository;

    private $userRepository;

    private $syncRepository;

    private $externalDataTypeRepository;

    private $externalDataRepository;

    private $dealRepository;

    private $dealEntryRepository;

    private $exchangeService;

    private $entityRepository;

    private $addressRepository;

    public function __construct()
    {
        $this->projectRepository = new ProjectRepository;
        $this->userRepository = new UserRepository;
        $this->syncRepository = new SyncRepository;
        $this->externalDataTypeRepository = new ExternalDataTypeRepository;
        $this->externalDataRepository = new ExternalDataRepository;
        $this->dealRepository = new DealRepository;
        $this->dealEntryRepository = new DealEntryRepository;
        $this->exchangeService = new ExchangeService;
        $this->entityRepository = new EntityRepository;
        $this->addressRepository = new AddressRepository;
    }

    public function findMany($project, $queryType)
    {
        $project = $this->projectRepository->findProjectById($project->id);

        $drive = config('projects.'.$project->name.'.db_connection');
        $server = config('projects.'.$project->name.'.db_host');
        $port = config('projects.'.$project->name.'.db_port');
        $database = config('projects.'.$project->name.'.db_name');
        $username = config('projects.'.$project->name.'.db_username');
        $password = config('projects.'.$project->name.'.db_password');

        if ($drive == Connection::MYSQL->value) {
            $connection = new PDO("$drive:host=$server;port=$port;dbname=$database", $username, $password);
        } else {
            $connection = new PDO("$drive:server=$server;Database=$database", $username, $password);
        }

        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = config('projects.'.$project->name.'.'.$queryType);

        $userQuery = $connection->prepare($query);
        $userQuery->execute();

        $users = $userQuery->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }

    public function storeUsers($project, $queryType)
    {
        $users = $this->findMany($project, $queryType);

        try {
            DB::beginTransaction();
            foreach ($users as $user) {
                if (! in_array(strtolower($user['Email']), config('projects.ignore_users')) && trim($user['FirstName']) && trim($user['LastName'])) {
                    $userData = $this->userRepository->findUser(strtolower($user['Email']), trim($user['FirstName']), trim($user['LastName']));
                    $externalUserDataType = $this->externalDataTypeRepository->showByName(config('projects.'.$project->name.'.user_data_type'));
                    if ($project->name == 'Craftwill Capital ESG') {
                        if ($userData) {
                            $existing_user = $userData['user'];
                            $method = $userData['method'];
                            if ($method != 'email' && $existing_user->email != strtolower($user['Email'])) {
                                $existing_user = $this->userRepository->createUserFromSync($user);
                                $this->saveEntity($user, $existing_user);
                                $this->saveAddress($user, $existing_user);
                            }
                            $this->syncRole($existing_user, $user, config('projects.'.$project->name.'.roles'));
                            $this->createUserExternalData($user, $existing_user, $externalUserDataType);
                            $this->syncRepository->store($project->id, json_encode($user), json_encode(['user' => $existing_user]));
                        } else {
                            $newUser = $this->userRepository->createUserFromSync($user);
                            $this->saveEntity($user, $newUser);
                            $this->saveAddress($user, $newUser);
                            $this->syncRole($newUser, $user, config('projects.'.$project->name.'.roles'));
                            $this->createUserExternalData($user, $newUser, $externalUserDataType);
                            $this->syncRepository->store($project->id, json_encode($user), json_encode(['user' => $newUser]));
                        }
                    } else {
                        if ($userData) {
                            $existing_user = $userData['user'];
                            $this->mergeUser($user, $existing_user, $externalUserDataType);
                            $this->createUserExternalData($user, $existing_user, $externalUserDataType);
                            $this->syncRepository->store($project->id, json_encode($user), json_encode(['user' => $existing_user]));
                        } else {
                            $newUser = $this->userRepository->createUserFromSync($user);
                            $this->createUserExternalData($user, $newUser, $externalUserDataType);
                            $this->syncRepository->store($project->id, json_encode($user), json_encode(['user' => $newUser]));
                        }
                    }
                }
            }
            DB::commit();

            return true;
        } catch (Throwable $e) {
            Log::info($e->getMessage());
            DB::rollBack();
        }
    }

    public function storeShares($project, $queryType)
    {
        $users = $this->findMany($project, $queryType);

        try {
            DB::beginTransaction();
            foreach ($users as $user) {
                if (! in_array(strtolower($user['Email']), config('projects.ignore_users')) && trim($user['FirstName']) && trim($user['LastName'])) {
                    $data = null;
                    $existing_user = null;
                    $userData = $this->userRepository->findUser(strtolower($user['Email']), trim($user['FirstName']), trim($user['LastName']));
                    $externalUserDataType = $this->externalDataTypeRepository->showByName(config('projects.'.$project->name.'.user_data_type'));
                    if ($project->name == 'Craftwill Capital ESG') {
                        if ($userData) {
                            $existing_user = $userData['user'];
                            $method = $userData['method'];
                            if ($method != 'email' && $existing_user->email != strtolower($user['Email'])) {
                                $existing_user = $this->userRepository->createUserFromSync($user);
                                $this->saveEntity($user, $existing_user);
                                $this->saveAddress($user, $existing_user);
                            }
                            $this->syncRole($existing_user, $user, config('projects.'.$project->name.'.roles'));
                            $this->createUserExternalData($user, $existing_user, $externalUserDataType);
                            $data = ['user' => $existing_user];
                        } else {
                            $newUser = $this->userRepository->createUserFromSync($user);
                            $this->saveEntity($user, $newUser);
                            $this->saveAddress($user, $newUser);
                            $this->syncRole($newUser, $user, config('projects.'.$project->name.'.roles'));
                            $this->createUserExternalData($user, $newUser, $externalUserDataType);
                            $data = ['user' => $newUser];
                            $existing_user = $newUser;
                        }
                    } else {
                        if ($userData) {
                            $existing_user = $userData['user'];
                            $this->mergeUser($user, $existing_user, $externalUserDataType);
                            $this->createUserExternalData($user, $existing_user, $externalUserDataType);
                            $data = ['user' => $existing_user];
                        } else {
                            $newUser = $this->userRepository->createUserFromSync($user);
                            $this->createUserExternalData($user, $newUser, $externalUserDataType);
                            $data = ['user' => $newUser];
                            $existing_user = $newUser;
                        }
                    }
                    $sync = $this->syncRepository->store($project->id, json_encode($user), json_encode($data));
                    $transaction = null;

                    $externalShareDataType = $this->externalDataTypeRepository->showByName(config('projects.'.$project->name.'.share_data_type'));

                    if ($project->name == 'Craftwill Capital ESG') {
                        if (isset($user['CWIOP']) && $user['CWIOP'] > 0) {
                            $this->syncShares($user, $project, $externalShareDataType, $externalUserDataType, $existing_user, $sync, 'CWIOP');
                        }

                        if (isset($user['CWISC']) && $user['CWISC'] > 0) {
                            $this->syncShares($user, $project, $externalShareDataType, $externalUserDataType, $existing_user, $sync, 'CWISC');
                        }
                    } else {
                        if (isset($user['Balance']) && $user['Balance'] > 0) {
                            if (isset($user['TransactionType'])) {
                                $balance = $user['Balance'] / ($project->name == 'REES' ? 10000 : 1);
                                $transactionData = ['type' => $user['TransactionType'], 'amount' => number_format($balance, 4, '.', '')];
                                $tickerType = $user['WalletType'] === WalletType::Tokens->value ? 'token_ticker' : 'share_ticker';
                                $ticker = Ticker::where('ticker', config('projects.'.$project->name.'.'.$tickerType))->first();
                                $externalTransactionData = $this->externalDataRepository->showTransaction($user['WalletID'], $externalShareDataType->id);
                                if (! $externalTransactionData) {
                                    $externalUser = $this->externalDataRepository->showUser($user, $externalUserDataType);
                                    if ($externalUser) {
                                        $existing_user = $this->userRepository->findUserById($externalUser->externable_id);
                                    }
                                    $share_data = ['ticker' => [$ticker->id], 'shares' => number_format($balance, 4, '.', ''), 'description' => $user['Description'] ?? null, 'transaction_date' => $user['TransactionDate'] ?? null];
                                    $transaction = $this->exchangeService->buy($existing_user, $share_data, $sync, $transactionData);
                                    $this->externalDataRepository->storeTransaction($user['WalletID'], $user, $externalShareDataType->id, $transaction);
                                }
                            } else {
                                $externalTransactionData = $this->externalDataRepository->showTransaction($user['WalletID'], $externalShareDataType->id);
                                if (! $externalTransactionData) {
                                    $externalUser = $this->externalDataRepository->showUser($user, $externalUserDataType);
                                    if ($externalUser) {
                                        $existing_user = $this->userRepository->findUserById($externalUser->externable_id);
                                    }
                                    $ticker = Ticker::where('ticker', config('projects.'.$project->name.'.share_ticker'))->first();
                                    $abc_data = ['ticker' => [$ticker->id], 'shares' => $user['Balance'], 'transaction_date' => $user['TransactionDate'] ?? null];
                                    $transaction = $this->exchangeService->buy($existing_user, $abc_data, $sync);
                                    $this->externalDataRepository->storeTransaction($user['WalletID'], $user, $externalShareDataType->id, $transaction);
                                    $equalShares = config('projects.'.$project->name.'.equal_shares');
                                    if (isset($equalShares)) {
                                        $transactionArray = [];
                                        foreach ($equalShares as $equalShare) {
                                            $ticker = Ticker::where('ticker', $equalShare)->first();
                                            $abc_data = ['ticker' => [$ticker->id], 'shares' => $user['Balance'], 'transaction_date' => $user['TransactionDate'] ?? null];
                                            $transactionData = $this->exchangeService->buy($existing_user, $abc_data, $sync);
                                            $this->externalDataRepository->storeTransaction($user['WalletID'], $user, $externalShareDataType->id, $transactionData);
                                            $transactionArray[] = $transactionData;
                                        }
                                        $transaction = $transactionArray;
                                    }
                                }
                            }
                        }
                    }

                    $this->syncRepository->updateResults($sync->id, json_encode(['user' => $existing_user, 'transaction' => $transaction]));
                }
            }
            DB::commit();

            return true;
        } catch (Throwable $e) {
            Log::info($e->getMessage());
            DB::rollBack();
        }
    }

    public function syncTgiBankTransactions($project, $queryType)
    {
        $users = $this->findMany($project, $queryType);

        try {
            DB::beginTransaction();
            foreach ($users as $user) {
                $amount = $this->getAmount($user);
                $externalTransactionDataType = $this->externalDataTypeRepository->showByName(config('projects.'.$project->name.'.transaction_data_type'));
                if ($amount) {
                    $existingUser = $this->userRepository->findUserByEmail(strtolower($user['Email']));
                    if (! $existingUser) {
                        $existingUser = $this->userRepository->createUserFromSync($user);
                        $this->saveEntity($user, $existingUser);
                        $this->saveAddress($user, $existingUser);
                    }
                    $dealPayload = (object) [
                        'name' => 'VolverZen to Global EXIM',
                        'date' => Carbon::today(),
                    ];
                    $payload = (object) [
                        'user_id' => $existingUser->id,
                        'dealable_quantity' => $amount,
                        'billable_price' => 0,
                        'billable_quantity' => 0,
                        'status' => Status::Accepted->value,
                    ];
                    $ticker = Ticker::where('ticker', 'EXIM')->first();
                    $existingDeal = $this->dealRepository->findDealByName($dealPayload->name);
                    if (! $existingDeal) {
                        $existingDeal = $this->dealRepository->create($dealPayload, $ticker);
                    }
                    $dealEntry = $this->dealEntryRepository->getDealByUserIdDealIdDealableQuantity($existingUser->id, $existingDeal->id, $payload->dealable_quantity);
                    if (! $dealEntry) {
                        $this->dealEntryRepository->storeDealEntry($payload, $existingDeal);
                        $transaction = $this->exchangeService->buy($existingUser, ['ticker' => [$ticker->id], 'shares' => $amount]);
                        $this->externalDataRepository->storeTransaction($existingDeal->id, $existingDeal, $externalTransactionDataType->id, $transaction);
                    }
                }
            }
            DB::commit();

            return true;
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
        }
    }

    public function getAmount($user)
    {
        switch ($user['Description']) {
            case 'License 2400':
                $amount = 960;
                break;
            case 'Payment for "Partner 2,400"':
                $date = new DateTime($user['CreatedOnDate']);
                $validDate = new DateTime('2019-10-01');
                if ($date->format('Y-m-d') < $validDate->format('Y-m-d')) {
                    $amount = 960;
                } else {
                    $amount = null;
                }
                break;
            case 'Funding account':
                $amount = $user['Amount'];
                break;
            case 'License 200':
            case 'Payment for "Partner 200"':
            case 'Payment for "Partner 500"':
            case 'Payment for "Partner 1,200"':
            case 'Payment for "Partner 2,500"':
            case 'Payment for "Partner 5,000"':
                $amount = null;
                break;
            default:
                $amount = $user['Amount'];
        }

        return $amount;
    }

    public function syncRole($currentUser, $user, $roles)
    {
        try {
            $userRole = $user['RoleName'];

            if (in_array($userRole, $roles)) {
                for ($i = 0; $i < count($roles); $i++) {
                    if ($currentUser->hasRole($roles[$i])) {
                        $role = Role::where('name', $roles[$i])->first();
                        $currentUser->removeRole($role);
                        break;
                    } else {
                        break;
                    }
                }
                $currentUser->assignRole($userRole);
            }

            return true;
        } catch (Throwable $e) {
            Log::debug($e->getMessage());
        }
    }

    public function createUserExternalData($user, $currentUser, $externalDataType): void
    {
        $externalUserData = $this->externalDataRepository->showUser($user, $externalDataType);
        if (! $externalUserData) {
            $this->externalDataRepository->storeUser($user, $externalDataType->id, $currentUser);
        }
    }

    public function mergeUser($user, $currentUser, $externalUserDataType): void
    {
        $externalUser = $this->externalDataRepository->showUserExternalData(strtolower($user['Email']), $externalUserDataType->id);
        if (! $externalUser) {
            if ($currentUser && ! $currentUser->secondary_email && $currentUser->email != strtolower($user['Email'])) {
                $this->userRepository->storeSecondaryEmail(strtolower($user['Email']), $currentUser->id);
            } else {
                if ($currentUser && $currentUser->secondary_email != strtolower($user['Email']) && ! $currentUser->third_email && $currentUser->email != strtolower($user['Email'])) {
                    $this->userRepository->storeThirdEmail(strtolower($user['Email']), $currentUser->id);
                }
            }
        }
    }

    public function syncShares($user, $project, $externalShareDataType, $externalUserDataType, $currentUser, $sync, $sharesType): void
    {
        $externalTransactionData = $this->externalDataRepository->showTransaction($user[$sharesType.'_ID'], $externalShareDataType->id);
        if (! $externalTransactionData) {
            $externalUser = $this->externalDataRepository->showUser($user, $externalUserDataType);
            if ($externalUser) {
                $currentUser = $this->userRepository->findUserById($externalUser->externable_id);
            }
            $ticker = Ticker::where('ticker', config('projects.'.$project->name.'.'.$sharesType.'_ticker'))->first();
            $sharesData = ['ticker' => [$ticker->id], 'shares' => $user[$sharesType], 'transaction_date' => $user['TransactionDate'] ?? null];
            $transaction = $this->exchangeService->buy($currentUser, $sharesData, $sync);
            $this->externalDataRepository->storeTransaction($user[$sharesType.'_ID'], $user, $externalShareDataType->id, $transaction);
        }
    }

    public function saveEntity($userData, $currentUser): void
    {
        if (isset($userData['Company']) && $userData['Company'] == '1') {
            $name = isset($userData['CompanyName']) ? $userData['CompanyName'] : trim($userData['FirstName']).' '.trim($userData['LastName']);
            $entityType = EntityType::where('name', 'Company')->first();
            $this->entityRepository->store($name, $entityType, $currentUser);
        }

        if (isset($userData['Company']) && $userData['Company'] == '0' || $userData['Company'] == null) {
            $name = trim($userData['FirstName']).' '.trim($userData['LastName']);
            $entityType = EntityType::where('name', 'Individual')->first();
            $this->entityRepository->store($name, $entityType, $currentUser);
        }
    }

    public function saveAddress($userData, $currentUser): void
    {
        if (isset($userData['MobileNumber']) || isset($userData['Unit']) || isset($userData['Street']) || isset($userData['City']) || isset($userData['Country']) || isset($userData['Region']) || isset($userData['PostalCode'])) {

            $payload = (object) [
                'street' => $userData['Street'],
                'city' => $userData['City'],
                'postal' => $userData['PostalCode'],
                'countries_id' => ($userData['Country'] == '157') ? 158 : 54,
            ];

            $this->addressRepository->storeAddress($payload, $currentUser);
        }
    }
}
