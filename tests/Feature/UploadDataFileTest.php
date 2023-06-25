<?php

namespace Tests\Feature;

use App\Jobs\LoadProcessBatch;
use Illuminate\Bus\PendingBatch;
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

        Bus::fake();

        $response->assertStatus(201);

        Bus::assertBatched(function (PendingBatch $batch) {
            return $batch->name === 'process-import';
        });
    }
}
