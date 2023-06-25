<?php

namespace App\Contracts;

interface FileImporterInterface {

    /**
     * Import data from a file at the specified file path.
     * 
     * @param string $filePath
     * @return array
     */
    public function import(string $filePath): array;

    /**
     * Validate the data against the specified rules
     * 
     * @param array $data
     * @param array $rules
     * @return void
     */
    public function validate(array $data, array $rules): void;
}