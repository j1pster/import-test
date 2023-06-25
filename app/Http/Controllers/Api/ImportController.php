<?php

namespace App\Http\Controllers\Api;

use App\Models\Import;
use Illuminate\Http\Request;
use App\Jobs\ProcessRecordsJob;
use App\Http\Controllers\Controller;
use App\Contracts\FileImporterInterface;
use App\Jobs\LoadProcessBatch;
use App\Services\ProcessData\ProcessRecords;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class ImportController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Import::all();
    }

    /**
     * Save the uploaded file to storage and dispatch a batch job to process the data.
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Contracts\FileImporterInterface $fileImporter
     * 
     */
    public function store(Request $request, FileImporterInterface $fileImporter)
    {
        // dd($request->file);
        $request->validate([
            // 'file' => 'required|file|mimes:json' // For some reason the challenge.json fails this rule.
        ]);

        $file = $request->file('file');
        $folderPath = 'uploads/' . date('Y') . '/' . date('m');
        $fileName = $file->getClientOriginalName() . '-' . time() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs($folderPath, $fileName);

        $import = Import::create([
            'name' => $file->getClientOriginalName(),
            'path' => $filePath,
            'status' => 'processing'
        ]);

        $processRecords = new ProcessRecords();
        $rules = $processRecords->rules();

        $data = $fileImporter->import(storage_path('app/' . $filePath));

        $fileImporter->validate($data, $rules);

        $batch = Bus::batch([
            new LoadProcessBatch($import, $data, $processRecords),
        ])
        ->allowFailures()
        ->then(function (Batch $batch) use ($import) {
            $import->update(['status' => 'completed']);
        })
        ->catch(function (Batch $batch, \Throwable $e) use ($import) {
            $import->update(['status' => 'failed']);
            Log::error($e->getMessage());
        })
        ->name('process-import')
        ->dispatch();

        return $import;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Import::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
