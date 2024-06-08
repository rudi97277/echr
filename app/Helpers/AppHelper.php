<?php

namespace App\Helpers;

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
}
