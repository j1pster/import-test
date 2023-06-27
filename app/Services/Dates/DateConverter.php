<?php

namespace App\Services\Dates;

use Carbon\Exceptions\InvalidDateException;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Carbon;

class DateConverter
{

    /**
     * Convert a date in unknown format to a Carbon instance.
     * 
     * @param string $dateString
     * @return Carbon|null
     */
    public static function convertToDateTime($dateString): ?Carbon
    {
        try {
            return Carbon::parse($dateString);
        } catch (\Exception $e) {
            // Add more formats here if needed. 
            $formats = [
                'Y-m-d',
                'Y/m/d',
                'Y-m-d\TH:i:sP',
            ];
    
            foreach ($formats as $format) {
                try {
                    $date = Carbon::createFromFormat($format, $dateString);
                } catch (InvalidFormatException $e) {
                    continue;
                }
                if ($date && !$date->isInvalid()) {
                    return $date;
                }
            }
    
            return null;
        }

    }
}