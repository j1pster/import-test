<?php

namespace App\Jobs;

use App\Models\Import;
use App\Models\Record;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Traits\RecordValidation;
use Illuminate\Support\Facades\Validator;

class ProcessImportData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, RecordValidation;

    protected $import;
    protected $data;

    /**
     * The number of times the job may be attempted.
     */
    public $tries = 0;

    /**
     * Create a new job instance.
     */
    public function __construct(Import $import, array $data)
    {
        $this->import = $import;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::transaction(function () {
            foreach($this->data as $row) {
                $validated = $this->validate($row);
                if(!$validated) {
                    continue;
                }
                $processed = $this->processRow($validated);
                Record::create($processed);
            }
        });
    }

    public function validate($row) {
        $rules = $this->recordRules();
        $validator = Validator::make($row, $rules);

        if ($validator->fails()) {
            return false;
        }

        return $validator->validated();
    }

    public function processRow($row) {
        $row['import_id'] = $this->import->id;

        $creditCard = $row['credit_card'];

        $row['credit_card_name'] = $creditCard['name'];
        $row['credit_card_number'] = $creditCard['number'];
        $row['credit_card_expiration_date'] = $creditCard['expirationDate'];
        $row['credit_card_type'] = $creditCard['type'];

        unset($row['credit_card']);

        return $row;
    }
}
