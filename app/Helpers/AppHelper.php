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
        return Str::random(10) . base64_encode($key);
    }

    public static function unObfuscate(string $obfuscatedString)
    {
        return base64_decode(substr($obfuscatedString, 10));
    }

    public static function formatRupiah(float $number)
    {
        return "Rp " . number_format($number, 0, ",", ".");
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
                    'name' => ucfirst($part),
                    'url' => $url
                ];
            }
        }

        return $breadcrumbs;
    }
}
