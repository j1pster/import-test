<?php

namespace App\Http\Controllers\Api;

use App\Models\Import;
use Illuminate\Http\Request;
use App\Jobs\ProcessRecordsJob;
use App\Http\Controllers\Controller;
use App\Contracts\FileImporterInterface;
use App\Services\ProcessData\ProcessRecords;

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
     * Store a newly created resource in storage.
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

        $data = $fileImporter->import(storage_path('app/' . $filePath), $rules);

        $chunks = array_chunk($data, 1000);

        foreach ($chunks as $chunk) {

            ProcessRecordsJob::dispatch($import, $chunk, $processRecords);
        }

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
