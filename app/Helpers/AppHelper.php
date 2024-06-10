<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;

class AppHelper
{
    public static function obfuscate(string $key)
    {
        return Str::random(10) . base64_encode($key);
    }

    public static function unObfuscate(string $obfuscatedString)
    {
        return base64_decode(substr($obfuscatedString, 10));
    }

    public static function today()
    {
        Carbon::setLocale('id');
        return Carbon::now()->isoFormat('dddd, DD MMMM YYYY');
    }

    public static function paginationData($data)
    {
        return collect($data)->only('from', 'to', 'per_page', 'total', 'last_page', 'next_page_url', 'prev_page_url', 'current_page');
    }
}
