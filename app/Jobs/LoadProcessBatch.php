<?php

namespace App\Jobs;

use App\Models\Import;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LoadProcessBatch implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $import;
    protected $data;
    protected $processRecords;
    /**
     * Create a new job instance.
     */
    public function __construct(Import $import, array $data, $processRecords)
    {
        $this->import = $import;
        $this->data = $data;
        $this->processRecords = $processRecords;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        $chunks = array_chunk($this->data, 1000);

        foreach ($chunks as $chunk) {
            $this->batch()->add(new ProcessRecordsJob($this->import, $chunk, $this->processRecords));
        }

    }
}
