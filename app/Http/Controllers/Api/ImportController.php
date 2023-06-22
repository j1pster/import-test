<?php

namespace App\Http\Controllers\Api;

use App\Contracts\FileImporter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FileImporter\JsonFileImporter;

class ImportController extends Controller
{
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
        //TODO: implement store method.
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
