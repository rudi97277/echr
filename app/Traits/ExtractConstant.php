<?php

namespace App\Traits;


trait ExtractConstant
{
    public static function getAllConstants(): array
    {
        $reflectionClass = new \ReflectionClass(__CLASS__);
        return $reflectionClass->getConstants();
    }
}
