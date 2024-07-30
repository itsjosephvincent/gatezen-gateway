<?php

namespace App\Services;

use App\Http\Resources\LanguageResource;
use App\Interface\Repositories\LanguageRepositoryInterface;
use App\Interface\Services\LanguageServiceInterface;

class LanguageService implements LanguageServiceInterface
{
    private $languageRepository;

    public function __construct(LanguageRepositoryInterface $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    public function getLanguageList()
    {
        $languages = $this->languageRepository->findMany();

        return LanguageResource::collection($languages);
    }
}
