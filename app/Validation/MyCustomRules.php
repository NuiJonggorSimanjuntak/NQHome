<?php

namespace App\Validation;

use CodeIgniter\Validation\Validation;
use CodeIgniter\Validation\Exceptions\ValidationException;

class MyCustomRules
{
    // public function valid_date(string $str, string $format): bool
    // {
    //     $d = \DateTime::createFromFormat($format, $str);
    //     return $d && $d->format($format) === $str;
    // }

    // public function valid_time(string $str, string $format): bool
    // {
    //     $timeFormat = str_replace(':s', '', $format);
    //     $t = \DateTime::createFromFormat($timeFormat, $str);
    //     $formattedTime = $t ? $t->format($timeFormat) : null;
    //     return $formattedTime === $str;
    // }
}
