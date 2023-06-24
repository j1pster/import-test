<?php

namespace App\Http\Controllers\Api;

use App\Contracts\FileImporter;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessImportData;
use App\Models\Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\RecordValidation;

class ImportController extends Controller
{

    use RecordValidation;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, FileImporter $fileImporter)
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

        $data = $fileImporter->import(storage_path('app/' . $filePath), $this->recordRules());

        $chunks = array_chunk($data, 1000);

        foreach ($chunks as $chunk) {

            ProcessImportData::dispatch($import, $chunk);
        }

        return $import;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
