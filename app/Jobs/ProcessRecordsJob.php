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
use Illuminate\Support\Facades\Validator;
use App\Services\ProcessData\ProcessRecords;
use App\Services\Dates\DateConverter;

class ProcessRecordsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $import;
    protected $data;
    protected $processRecords;
    protected $created_at;

    /**
     * The number of times the job may be attempted.
     */
    public $tries = 0;

    /**
     * Create a new job instance.
     */
    public function __construct(Import $import, array $data, ProcessRecords $processRecords)
    {
        $this->import = $import;
        $this->data = $data;
        $this->processRecords = $processRecords;
        $this->created_at = now();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::transaction(function () {
            $validRows = [];
            foreach($this->data as $row) {
                $validated = $this->validate($row);
                $processed = $this->processRow($validated);
                $passesFilters = $this->passesFilters($processed);
                
                if(!$validated || !$passesFilters) {
                    continue;
                }
                $validRows[] = $processed;
            }
            Record::insert($validRows);
        });
    }

    public function validate($row) {
        $rules = $this->processRecords->rules();
        $validator = Validator::make($row, $rules);

        if ($validator->fails()) {
            return false;
        }

        return $validator->validated();
    }

    public function passesFilters($row) {
        $filters = $this->processRecords->filters();

        foreach($filters as $filter) {
            if(!$filter->passes($row)) {
                return false;
            }
        }

        return true;
    }

    public function processRow($row) {
        $row['import_id'] = $this->import->id;

        $creditCard = $row['credit_card'];

        $row['date_of_birth'] = DateConverter::convertToDateTime($row['date_of_birth']);

        $row['credit_card_name'] = $creditCard['name'];
        $row['credit_card_number'] = $creditCard['number'];
        $row['credit_card_expiration_date'] = $creditCard['expirationDate'];
        $row['credit_card_type'] = $creditCard['type'];
        $row['created_at'] = $this->created_at;
        $row['updated_at'] = $this->created_at;

        unset($row['credit_card']);

        return $row;
    }
}
