<?php

namespace App\Services\FileImporter;

use App\Contracts\FileImporterInterface;
use Illuminate\Support\Facades\Validator;

class JsonFileImporter implements FileImporterInterface
{

    /**
     * {@inheritdoc}
     * 
     * Get the contents from the file path and decode them as JSON.
     * 
     */
    public function import(string $filePath): array
    {
        $file = file_get_contents($filePath, 'r');
        $data = json_decode($file, true);

        return $data ?? [];
    }
    
    /**
     * {@inheritdoc}
     * 
     * Validate the first row of the imported JSON data.
     * This is to ensure that the data is in the correct format before continuing.
     * 
     * @throws \InvalidArgumentException
     * @throws \Illuminate\Validation\ValidationException
     * 
     */
    public function validate(array $data, array $rules): void
    {   
        if($data === null) {
            throw new \InvalidArgumentException('Invalid JSON file.');
        }

        $first = reset($data);

        if (!is_array($first)) {
            throw new \InvalidArgumentException('Invalid JSON file.');
        }

        Validator::make($first, $rules)->validate();
    }
}