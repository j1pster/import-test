<?php

namespace App\Contracts;

interface FileImporter {
    public function import(string $filePath): array;
}