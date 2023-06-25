<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Services\FileImporter\JsonFileImporter;
use App\Services\ProcessData\ProcessRecords;

class JsonFileImporterTest extends TestCase
{

    public function validRules() {
        $processRecords = new ProcessRecords();
        return $processRecords->rules();
    }
    /**
     * @test
     */
    public function json_file_importer_successfully_imports_json_file() {
        $jsonFileImporter = new JsonFileImporter();
        $data = $jsonFileImporter->import(storage_path('tests/example.json'), $this->validRules());

        $this->assertIsArray($data);
        $this->assertCount(5, $data);
    }
}
