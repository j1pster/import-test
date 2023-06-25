<?php

namespace App\Services\Dates;

use Carbon\Exceptions\InvalidDateException;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Carbon;

class DateConverter
{
    public static function convertToDateTime($dateString)
    {
        try {
            return Carbon::parse($dateString);
        } catch (\Exception $e) {
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