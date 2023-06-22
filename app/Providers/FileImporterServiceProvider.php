<?php

namespace App\Providers;

use App\Services\FileImporter\JsonFileImporter;
use App\Contracts\FileImporter;
use Illuminate\Support\ServiceProvider;

class FileImporterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(FileImporter::class, function ($app) {
            $uploadedFile = $app->make('request')->file('file');
            $fileExtension = $uploadedFile->getClientOriginalExtension();

            // Choose the appropriate FileImporter based on the file extension
            switch ($fileExtension) {
                case 'json':
                    return new JsonFileImporter();
                //case 'csv':
                    // return CSV File Importer;
                //case 'xls':
                //case 'xlsx':
                    // return Excel File Importer;
                default:
                    throw new \InvalidArgumentException('Unsupported file type.');
            }
        });
    }
}