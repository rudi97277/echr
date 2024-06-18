<?php

namespace App\Exports;

use App\Models\Payslip;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class PayslipExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStrictNullComparison
{

    public function __construct(
        public int $payrollId
    ) {
    }

    public function query()
    {
        return Payslip::join('employees as e', 'e.id', 'payslips.employee_id')
            ->select('e.name', 'e.bank_name', 'e.bank_number', 'total', 'workday', DB::raw("DATE_FORMAT(payslips.created_at,'%d/%m/%Y') as date"))
            ->where('payroll_id', $this->payrollId);
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Nama Bank',
            'Nomor Bank',
            'Total',
            'Hari Kerja',
            'Tanggal',
        ];
    }

    public function map($row): array
    {
        static $rowNumber = 0;

        return [
            ++$rowNumber,
            $row->name,
            $row->bank_name,
            $row->bank_number,
            $row->total,
            $row->workday,
            $row->date,

        ];
    }
}
