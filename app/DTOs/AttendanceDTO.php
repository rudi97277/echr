<?php

namespace App\DTOs;


class AttendanceDTO
{
    public function __construct(
        public float $lat,
        public float $long,
        public string $image
    ) {
    }
}
