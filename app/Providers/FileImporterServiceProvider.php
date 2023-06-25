<?php

namespace App\Providers;

use App\Services\FileImporter\JsonFileImporter;
use App\Contracts\FileImporterInterface;
use Illuminate\Support\ServiceProvider;

class FileImporterServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     * 
     * Every time we need an implementation of FileImporterInterface
     * we check the file extension of the uploaded file and bind the appropriate FileImporter.
     * 
     * @return void
     */
    public function register()
    {
        $this->app->bind(FileImporterInterface::class, function ($app) {
            $uploadedFile = $app->make('request')->file('file');
            $fileExtension = $uploadedFile->getClientOriginalExtension();

            // Choose the appropriate FileImporter based on the file extension
            switch ($fileExtension) {
                case 'json':
                    return new JsonFileImporter();
                // Example of how to add additional file types
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