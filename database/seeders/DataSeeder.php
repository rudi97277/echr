<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Enums\SalaryEnum;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Models\Form;
use App\Models\FormComponent;
use App\Models\FormDetail;
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
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                "name" => $i == 0 ? "Rudianto Sihombing" : fake()->name(),
                "email" => $i == 0 ? "rudi97278@gmail.com" : fake()->email(),
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

        FormComponent::insert([
            [
                'code' => 'date',
                'name' => 'Hari / Tanggal',
                'component' => 'x-form.date'
            ],
            [
                'code' => 'employee',
                'name' => 'Teknisi',
                'component' => 'x-form.employee'
            ],
            [
                'code' => 'customer_name',
                'name' => 'Pelanggan',
                'component' => 'x-form.customer_name'
            ],
            [
                'code' => 'customer_id',
                'name' => 'Id Pelanggan',
                'component' => 'x-form.customer_id'
            ],
            [
                'code' => 'location',
                'name' => 'Lokasi',
                'component' => 'x-form.location'
            ],
            [
                'code' => 'activity',
                'name' => 'Kegiatan',
                'component' => 'x-form.activity'
            ],
            [
                'code' => 'transport',
                'name' => 'Transportasi',
                'component' => 'x-form.transport'
            ],
            [
                'code' => 'package',
                'name' => 'Paket',
                'component' => 'x-form.package'
            ],
            [
                'code' => 'ref',
                'name' => 'Refrensi',
                'component' => 'x-form.ref'
            ],
        ]);

        Form::insert([
            [
                'name' => 'Form Pengajuan Pelanggan',
                'amount' => 50000
            ],
            [
                'name' => 'Form Lembur',
                'amount' => 50000
            ],
            [
                'name' => 'Form Pekerjaan',
                'amount' => 50000
            ],
            [
                'name' => 'Form Perbaikan',
                'amount' => 50000
            ],
            [
                'name' => 'Form Pemasangan Baru',
                'amount' => 50000
            ],
        ]);

        FormDetail::insert([
            [
                'form_id' => 1,
                'component_code' => 'date',
            ],
            [
                'form_id' => 1,
                'component_code' => 'customer_name',
            ],
            [
                'form_id' => 1,
                'component_code' => 'customer_id',
            ],
            [
                'form_id' => 1,
                'component_code' => 'location',
            ],
            [
                'form_id' => 1,
                'component_code' => 'package',
            ],
            [
                'form_id' => 1,
                'component_code' => 'ref',
            ],
            [
                'form_id' => 2,
                'component_code' => 'date',
            ],
            [
                'form_id' => 2,
                'component_code' => 'employee',
            ],
            [
                'form_id' => 2,
                'component_code' => 'customer_name',
            ],
            [
                'form_id' => 2,
                'component_code' => 'location',
            ],
            [
                'form_id' => 2,
                'component_code' => 'activity',
            ],
            [
                'form_id' => 2,
                'component_code' => 'transport',
            ],
            [
                'form_id' => 3,
                'component_code' => 'date',
            ],
            [
                'form_id' => 3,
                'component_code' => 'employee',
            ],
            [
                'form_id' => 3,
                'component_code' => 'customer_name',
            ],
            [
                'form_id' => 3,
                'component_code' => 'location',
            ],
            [
                'form_id' => 3,
                'component_code' => 'activity',
            ],
            [
                'form_id' => 4,
                'component_code' => 'date',
            ],
            [
                'form_id' => 4,
                'component_code' => 'employee',
            ],
            [
                'form_id' => 4,
                'component_code' => 'customer_name',
            ],
            [
                'form_id' => 4,
                'component_code' => 'location',
            ],
            [
                'form_id' => 4,
                'component_code' => 'activity',
            ],
            [
                'form_id' => 4,
                'component_code' => 'transport',
            ],
            [
                'form_id' => 5,
                'component_code' => 'date',
            ],
            [
                'form_id' => 5,
                'component_code' => 'customer_name',
            ],
            [
                'form_id' => 5,
                'component_code' => 'customer_id',
            ],

            [
                'form_id' => 5,
                'component_code' => 'location',
            ],
            [
                'form_id' => 5,
                'component_code' => 'employee',
            ],
            [
                'form_id' => 5,
                'component_code' => 'transport',
            ],
        ]);
    }
}
