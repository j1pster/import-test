<?php

namespace App\Services\Filters;

use App\Contracts\FilterInterface;
use Illuminate\Support\Carbon;

class AgeFilter implements FilterInterface
{
    private int $minAge;
    private int $maxAge;

    public function __construct($minAge, $maxAge)
    {
        $this->minAge = $minAge;
        $this->maxAge = $maxAge;
    }

    public function passes(array $data): bool
    {
        $date = $data['date_of_birth'];
        if (is_null($date)) {
            return false;
        }

        $now = Carbon::now();

        $age = $date->diffInYears($now);

        return $age >= $this->minAge && $age <= $this->maxAge;
    }
}