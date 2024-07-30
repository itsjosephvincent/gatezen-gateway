<?php

namespace App\Repositories;

use App\Interface\Repositories\LanguageRepositoryInterface;
use App\Models\Language;

class LanguageRepository implements LanguageRepositoryInterface
{
    public function findMany()
    {
        return Language::all();
    }
}
