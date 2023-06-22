<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Services\FileImporter\JsonFileImporter;

class JsonFileImporterTest extends TestCase
{
    /**
     * @test
     */
    public function json_file_importer_successfully_imports_json_file() {
        $jsonFileImporter = new JsonFileImporter();
        $data = $jsonFileImporter->import(storage_path('tests/example.json'));

        $this->assertIsArray($data);
        $this->assertCount(5, $data);
    }
}
