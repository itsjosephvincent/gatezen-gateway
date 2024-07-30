<?php

namespace App\Services;

use App\Http\Resources\CountryResource;
use App\Interface\Repositories\CountryRepositoryInterface;
use App\Interface\Services\CountryServiceInterface;

class CountryService implements CountryServiceInterface
{
    private $countryRepository;

    public function __construct(CountryRepositoryInterface $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function countryList()
    {
        $countries = $this->countryRepository->findMany();

        return CountryResource::collection($countries);
    }
}
