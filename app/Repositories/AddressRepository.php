<?php

namespace App\Repositories;

use App\Interface\Repositories\AddressRepositoryInterface;
use App\Models\Address;

class AddressRepository implements AddressRepositoryInterface
{
    public function findAddressByUser($user)
    {
        return Address::where('addressable_type', get_class($user))
            ->where('addressable_id', $user->id)
            ->first();
    }

    public function updateAddress($payload, $user)
    {
        $address = Address::where('addressable_type', get_class($user))
            ->where('addressable_id', $user->id)
            ->first();
        $address->co = $payload->co ?? $address->co;
        $address->street = $payload->street;
        $address->street2 = $payload->street2 ?? $address->street2;
        $address->city = $payload->city;
        $address->postal = $payload->postal;
        $address->county = $payload->county ?? $address->county;
        $address->countries_id = $payload->countries_id;
        $address->save();

        return $address->fresh();
    }

    public function storeAddress($payload, $user)
    {
        $address = new Address();
        $address->addressable_type = get_class($user);
        $address->addressable_id = $user->id;
        $address->street = $payload->street;
        $address->city = $payload->city;
        $address->postal = $payload->postal;
        $address->countries_id = $payload->countries_id;
        $address->save();

        return $address->fresh();
    }
}
