<?php

namespace App\Repositories;

use App\Interface\Repositories\CountryRepositoryInterface;
use App\Models\Country;

class CountryRepository implements CountryRepositoryInterface
{
    public function findMany()
    {
        return Country::all();
    }
}
