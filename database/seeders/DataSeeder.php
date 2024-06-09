<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Enums\SalaryEnum;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Models\Location;
use App\Models\Position;
use App\Models\Salary;
use App\Models\Shift;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::create([
            "name" => "Medan",
            "address" =>  "Jalan medan"
        ]);

        Position::create([
            "name" => "Teknisi"
        ]);

        Shift::create([
            "name" => "Shift Siang",
            "clock_in" => "17:00:00",
            "clock_out" => "23:00:00"
        ]);

        $data = [];
        for ($i = 0; $i < 40; $i++) {
            $data[] = [
                "name" => $i == 0 ? "Rudianto Sihombing" : 'User ' . Str::random(5),
                "email" => $i == 0 ? "rudi97278@gmail.com" : Str::random(10) . '@example.com',
                "password" => bcrypt("12345678"),
                "position_id" => 1,
                "shift_id" => 1,
                "location_id" => 1,
                "role" => $i == 0 ? RoleEnum::ADMINISTRATOR : null,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        Employee::insert($data);


        Salary::insert([
            [
                'code' => SalaryEnum::BASE_SALARY,
                'name' => 'Gaji Pokok',
                'type' => SalaryEnum::ADDITION,
            ],
            [
                'code' => SalaryEnum::ALLOWANCE,
                'name' => 'Tunjangan',
                'type' => SalaryEnum::ADDITION,
            ],
            [
                'code' => SalaryEnum::BONUS,
                'name' => 'Bonus',
                'type' => SalaryEnum::ADDITION,
            ],
            [
                'code' => SalaryEnum::BPJS,
                'name' => 'BPJS',
                'type' => SalaryEnum::SUBSTRACTION,
            ],
            [
                'code' => SalaryEnum::PH21,
                'name' => 'PH21',
                'type' => SalaryEnum::SUBSTRACTION,
            ],
        ]);

        EmployeeSalary::insert([
            [
                'employee_id' => 1,
                'salary_code' => SalaryEnum::BASE_SALARY,
                'amount' => 1000_000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'employee_id' => 1,
                'salary_code' => SalaryEnum::ALLOWANCE,
                'amount' => 100_000,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
