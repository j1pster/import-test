<?php

namespace Tests\Feature;

use App\Jobs\ProcessImportData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class UploadDataFileTest extends TestCase
{

    use RefreshDatabase;

    function getValidUploadedFile($name = 'example.json')
    {
        return new \Illuminate\Http\UploadedFile(
            storage_path('tests/' . $name),
            $name,
            'application/json',
            null,
            true
        );
    }

    /**
     * @test
     */
    public function uploading_a_valid_json_file_imports_content_to_the_database(): void
    {
        $response = $this->post('/api/import', [
            'file' => $this->getValidUploadedFile()
        ]);

        Queue::fake();

        $response->assertStatus(201);

        Queue::assertPushed(function (ProcessImportData $job) use ($response) {
            return $job->import->id === $response->json('id');
        });
    }
}
