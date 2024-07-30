<?php

namespace App\Services;

use App\Http\Resources\AddressResource;
use App\Interface\Repositories\AddressRepositoryInterface;
use App\Interface\Services\AddressServiceInterface;

class AddressService implements AddressServiceInterface
{
    private $addressRepository;

    public function __construct(AddressRepositoryInterface $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function getAddressByUserId($userId)
    {
        $address = $this->addressRepository->findAddressByUser($userId);

        return new AddressResource($address);
    }
}
