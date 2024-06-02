<?php

namespace Database\Seeders;

use App\Models\MEmployee;
use App\Models\MLocation;
use App\Models\MPosition;
use App\Models\MShift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MLocation::create([
            "name" => "Medan",
            "address" =>  "Jalan medan"
        ]);

        MPosition::create([
            "name" => "Teknisi"
        ]);

        MShift::create([
            "name" => "Shift Siang",
            "clock_in" => "10:00:00",
            "clock_out" => "23:00:00"
        ]);

        MEmployee::create([
            "name" => "Rudianto Sihombing",
            "email" => "rudi97278@gmail.com",
            "password" => bcrypt("123456"),
            "m_position_id" => 1,
            "m_shift_id" => 1,
            "m_location_id" => 1
        ]);
    }
}
