<?php

namespace App\Contracts;

interface ProcessDataInterface {

    /**
     * Provides a single source of truth list of rules for validating the imported data.
     */
    public function rules(): array;


    /**
     * Provides a single source of truth list of filters
     */
    public function filters(): array;
}