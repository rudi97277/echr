<?php

namespace App\Helpers;

use App\Enums\RoleEnum;
use App\Models\Setting;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class AppHelper
{
    public static function webName()
    {
        $max = 20;
        $name = self::fullWebName();
        $exploded = explode(' ', $name);
        $result = "";
        foreach ($exploded as $item) {
            if (strlen("$result $item") < $max)
                $result = "$result $item";
        }
        return $result;
    }

    public static function fullWebName()
    {
        return  Setting::first()?->web_name ?? 'Absensi';
    }
    public static function obfuscate(string $key)
    {
        $obfuscated =  Str::random(10) . base64_encode($key . mt_rand(10, 99));
        $len = strlen($obfuscated);
        $randomChar = chr(rand(0, 1) ? rand(65, 90) : rand(97, 122));
        return substr($obfuscated, 0, $len - 2) . $randomChar . substr($obfuscated, $len - 2);
    }

    public static function unObfuscate(string $obfuscatedString = null)
    {
        if ($obfuscatedString == null) return null;
        $len = strlen($obfuscatedString);
        $obfuscated = substr($obfuscatedString, 0, $len - 3) . substr($obfuscatedString, $len - 2);
        $base64Part = substr($obfuscated, 10);
        $decoded = base64_decode($base64Part);
        return substr($decoded, 0, -2);
    }

    public static function formatRupiah(float $number = null, bool $asHtml = true)
    {
        if ($number < 0)
            $result = number_format(abs($number), 0, ",", ".");
        else
            $result = number_format($number, 0, ",", ".");

        $minus = $number < 0 ? "-" : "";
        $class = $number < 0 ? "text-danger" : "";

        if (!$asHtml)
            return "$minus Rp $result";

        return "<span class='$class whitespace-nowrap'> {$minus}Rp $result</span>";
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

    public static function isUrl($string)
    {
        return filter_var($string, FILTER_VALIDATE_URL);
    }

    public static function toHourMinute($dateTime)
    {
        return Carbon::parse($dateTime)->format('H:i');
    }

    public static function administrator()
    {
        return RoleEnum::ADMINISTRATOR;
    }

    public static function currentParameters(array $additionals = [])
    {
        $params = Route::current()->parameters();
        $params = array_merge($params, $additionals);
        return $params;
    }

    public static function breadcrumbs()
    {
        $breadcrumbs = [];
        $current = Route::current();
        $routeName = $current->getName();
        $param = $current->parameters();
        $routeParts = explode('.', $routeName);

        $route = '';
        foreach ($routeParts as $idx => $part) {
            if ($idx == 0)
                $route = $part;
            else
                $route .= ".$part";

            if (Route::has($route)) {
                try {
                    $url = route($route);
                } catch (Exception $e) {
                    $url = route($route, $param);
                }
                $breadcrumbs[] = [
                    'name' => ucwords(str_replace('-', ' ', $part)),
                    'url' => $url
                ];
            }
        }

        return $breadcrumbs;
    }
}
