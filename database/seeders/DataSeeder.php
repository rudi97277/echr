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
            "name" => "NDC",
            "address" =>  "Jl. Selamat Pulau No.12 a, Sitirejo II, Kec. Medan Amplas, Kota Medan, Sumatera Utara 20219"
        ]);

        Position::insert([
            [
                "name" => "Admin"
            ],
            [
                "name" => "Marketing Freelance"
            ],
            [
                "name" => "Accounting"
            ], [
                "name" => "Teknisi"
            ]
        ]);

        Shift::insert([
            [
                "name" => "Full Time",
                "clock_in" => "09:00:00",
                "clock_out" => "17:00:00",
                "penalty_per_minutes" => 500,
            ],
            [
                "name" => "Shift Siang",
                "clock_in" => "14:30:00",
                "clock_out" => "17:30:00",
                "penalty_per_minutes" => 500
            ]
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
            // [
            //     'code' => SalaryEnum::BPJS,
            //     'name' => 'BPJS',
            //     'type' => SalaryEnum::SUBSTRACTION,
            // ],
            // [
            //     'code' => SalaryEnum::PH21,
            //     'name' => 'PH21',
            //     'type' => SalaryEnum::SUBSTRACTION,
            // ],
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
                'code' => '_1date',
                'name' => 'Hari / Tanggal',
                'component' => 'x-form.date'
            ],
            [
                'code' => '_2employee',
                'name' => 'Karyawan',
                'component' => 'x-form.employee'
            ],
            [
                'code' => '_3customer_name',
                'name' => 'Pelanggan',
                'component' => 'x-form.customer_name'
            ],
            [
                'code' => '_4customer_id',
                'name' => 'ID Pelanggan',
                'component' => 'x-form.customer_id'
            ],
            [
                'code' => '_5location',
                'name' => 'Lokasi',
                'component' => 'x-form.location'
            ],
            [
                'code' => '_6activity',
                'name' => 'Kegiatan',
                'component' => 'x-form.activity'
            ],
            [
                'code' => '_7transport',
                'name' => 'Transportasi',
                'component' => 'x-form.transport'
            ],
            [
                'code' => '_8package',
                'name' => 'Paket',
                'component' => 'x-form.package'
            ],
            [
                'code' => '_9ref',
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
                'component_code' => '_1date',
            ],
            [
                'form_id' => 1,
                'component_code' => '_3customer_name',
            ],
            [
                'form_id' => 1,
                'component_code' => '_4customer_id',
            ],
            [
                'form_id' => 1,
                'component_code' => '_5location',
            ],
            [
                'form_id' => 1,
                'component_code' => '_8package',
            ],
            [
                'form_id' => 1,
                'component_code' => '_9ref',
            ],
            [
                'form_id' => 2,
                'component_code' => '_1date',
            ],
            [
                'form_id' => 2,
                'component_code' => '_2employee',
            ],
            [
                'form_id' => 2,
                'component_code' => '_3customer_name',
            ],
            [
                'form_id' => 2,
                'component_code' => '_5location',
            ],
            [
                'form_id' => 2,
                'component_code' => '_6activity',
            ],
            [
                'form_id' => 2,
                'component_code' => '_7transport',
            ],
            [
                'form_id' => 3,
                'component_code' => '_1date',
            ],
            [
                'form_id' => 3,
                'component_code' => '_2employee',
            ],
            [
                'form_id' => 3,
                'component_code' => '_3customer_name',
            ],
            [
                'form_id' => 3,
                'component_code' => '_5location',
            ],
            [
                'form_id' => 3,
                'component_code' => '_6activity',
            ],
            [
                'form_id' => 4,
                'component_code' => '_1date',
            ],
            [
                'form_id' => 4,
                'component_code' => '_2employee',
            ],
            [
                'form_id' => 4,
                'component_code' => '_3customer_name',
            ],
            [
                'form_id' => 4,
                'component_code' => '_5location',
            ],
            [
                'form_id' => 4,
                'component_code' => '_6activity',
            ],
            [
                'form_id' => 4,
                'component_code' => '_7transport',
            ],
            [
                'form_id' => 5,
                'component_code' => '_1date',
            ],
            [
                'form_id' => 5,
                'component_code' => '_3customer_name',
            ],
            [
                'form_id' => 5,
                'component_code' => '_4customer_id',
            ],

            [
                'form_id' => 5,
                'component_code' => '_5location',
            ],
            [
                'form_id' => 5,
                'component_code' => '_2employee',
            ],
            [
                'form_id' => 5,
                'component_code' => '_7transport',
            ],
        ]);
    }
}
