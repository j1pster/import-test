<?php

namespace App\Contracts;

interface FileImporterInterface {
    public function import(string $filePath, array $rules): array;

    public function validate(array $data, array $rules): void;
}