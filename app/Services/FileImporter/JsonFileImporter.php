<?php

namespace App\Services\FileImporter;

use App\Contracts\FileImporter;
use Illuminate\Support\Facades\Validator;

class JsonFileImporter implements FileImporter
{

    public function import(string $filePath, array $rules): array
    {
        $file = file_get_contents($filePath, 'r');
        $data = json_decode($file, true);

        if($data === null) {
            throw new \InvalidArgumentException('Invalid JSON file.');
        }

        $this->validate($data, $rules);

        return $data ?? [];
    }

    /**
     * Validate the first row of the import against the specified rules, 
     * to check if the structure is correct. 
     */
    public function validate(array $data, array $rules): void
    {   
        $first = reset($data);

        if (!is_array($first)) {
            throw new \InvalidArgumentException('Invalid JSON file.');
        }
        Validator::make($first, $rules)->validate();
    }
}