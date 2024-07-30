<?php

namespace App\Services;

use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\MediaLibrary\Support\FileNamer\FileNamer;

class CustomMediaFilenameGenerator extends FileNamer
{
    public function originalFileName(string $fileName): string
    {
        $newFilename = md5($fileName);

        return pathinfo($newFilename, PATHINFO_FILENAME);
    }

    public function conversionFileName(string $fileName, Conversion $conversion): string
    {
        $strippedFileName = pathinfo($fileName, PATHINFO_FILENAME);
        $newStrippedFilename = md5($strippedFileName);

        return "{$newStrippedFilename}-{$conversion->getName()}";
    }

    public function responsiveFileName(string $fileName): string
    {
        $newFilename = md5($fileName);

        return pathinfo($newFilename, PATHINFO_FILENAME);
    }
}
