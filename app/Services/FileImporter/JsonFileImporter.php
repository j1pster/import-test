<?php

namespace App\Services\FileImporter;

use App\Contracts\FileImporter;

class JsonFileImporter implements FileImporter
{
    public function import(string $filePath): array
    {
        $file = file_get_contents($filePath, 'r');
        $data = json_decode($file, true);

        return $data ?? [];
    }
}