<?php

namespace App\Contracts;

interface FilterInterface 
{
    public function passes(array $data): bool;
}