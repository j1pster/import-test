<?php

namespace App\Contracts;

interface FilterInterface 
{

    /**
     * Filter the data array.
     * 
     * @param array $data
     * @return bool - true if the data passes the filter, false otherwise.
     */
    public function passes(array $data): bool;
}