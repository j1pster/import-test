<?php

namespace App\Contracts;

interface ProcessDataInterface {
    public function rules(): array;

    public function filters(): array;
}