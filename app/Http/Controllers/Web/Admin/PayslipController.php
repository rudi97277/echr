<?php

namespace App\Http\Controllers\Web\Admin;

use App\Exports\PayslipExport;
use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PayslipDetailResource;
use App\Http\Resources\PayslipResource;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\EmployeeForm;
use App\Models\Payroll;
use App\Models\Payslip;
use App\Models\PayslipDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PayslipController extends Controller
{
    public function index(Request $request)
    {
        $headers = [
            'Karyawan',
            'Nama Bank',
            'Nomor Bank',
            'Total',
            'Hari Kerja',
            'Tanggal'
        ];

        $payrolls = Payroll::orderBy('date', 'desc')->selectRaw("id, CONCAT(name,' - ',DATE_FORMAT(date,'%d/%m/%Y')) as name")->get();

        $target = $request->target ? AppHelper::unObfuscate($request->target) : $payrolls->first()?->id;

        $payslips = Payslip::join('employees as e', 'e.id', 'payslips.employee_id')
            ->select('payslips.id', 'e.name', 'e.bank_name', 'e.bank_number', 'total', 'workday', 'payslips.created_at')
            ->when($target, fn ($query) => $query->where('payroll_id', $target))
            ->paginate($request->input('page_size', 10));


        return view('layouts.admin.payslip', [
            'headers' => $headers,
            'payslips' => PayslipResource::collection($payslips),
            'payrolls' => $payrolls,
            'pagination' => AppHelper::paginationData($payslips),
            'target' => $target
        ]);
    }

    public function show(Request $request, string $obfuscatedId)
    {
        $headers = [
            'Nama',
            'Jumlah'
        ];

        $payslipId = AppHelper::unObfuscate($obfuscatedId);

        $payslipDetails = PayslipDetail::where('payslip_id', $payslipId)->select('id', 'name', 'amount')
            ->paginate($request->input('page_size', 10));

        return view('layouts.admin.payslip-detail', [
            'headers' => $headers,
            'pagination' => AppHelper::paginationData($payslipDetails),
            'payslipDetails' => PayslipDetailResource::collection($payslipDetails)
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "date" => "required|string",
            "name" => "required|string"
        ], [
            "date.required" => "Tanggal akhir payroll dibutuhkan!",
            "name.required" => "Nama payroll dibutuhkan!",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $date = Carbon::createFromFormat('d/m/y', $request->date)->format('Y-m-d');

        $payroll = Payroll::where('date', '>=', $date)->first();
        if ($payroll)
            return redirect()->back()->withErrors([
                'payroll' => 'Payroll untuk tanggal ini sudah ada!'
            ]);

        DB::transaction(function () use ($request, $date) {
            $payroll = Payroll::create([
                'name' => $request->name,
                'date' => $date
            ]);
            $employees = Employee::with([
                'attendances' => fn ($query) => $query->where('date', '<=', $date)
                    ->where(['is_paid' => 0])
                    ->selectRaw('COUNT(1) as total, IFNULL(SUM(amount),0) as penalty,SUM(in_minutes) as in_minutes,employee_id')
                    ->where(
                        fn ($query) => $query->whereNull('is_corrected')->orWhere('is_corrected', 0)
                    )
                    ->leftJoin('attendance_penalties as ap', 'ap.attendance_id', 'attendances.id')
                    ->groupBy('employee_id'),
                'forms' => fn ($query) => $query->where('date', '<=', $date)->where('is_paid', 0)
                    ->selectRaw('employee_id,employee_forms.amount,name')
                    ->join('forms as f', 'f.id', 'employee_forms.form_id'),
                'salaries' => fn ($query) => $query->selectRaw('amount,employee_id,name')
                    ->join('salaries as s', 's.code', 'employee_salaries.salary_code')
            ])
                ->select('id')
                ->get();

            foreach ($employees as $employee) {
                $details = [];
                $formDeduction = 0;
                $formDeductionDetails = [];
                $total = 0;
                $attendance = $employee->attendances->first();

                $payslip = Payslip::create([
                    'payroll_id' => $payroll->id,
                    'employee_id' => $employee->id,
                    'total' => $total,
                    'workday' => $attendance?->total ?? 0
                ]);

                foreach ($employee->salaries as $salary) {
                    $details[] = [
                        'payslip_id' => $payslip->id,
                        'name' => $salary->name,
                        'amount' => $salary->amount,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    $total += $salary->amount;
                }

                foreach ($employee->forms as $form) {

                    if ($form->amount < 0) {

                        $formDeductionDetails[] = [
                            'payslip_id' => $payslip->id,
                            'name' => $form->name,
                            'amount' => $form->amount,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];


                        $formDeduction += $form->amount;
                    } else {
                        $details[] = [
                            'payslip_id' => $payslip->id,
                            'name' => $form->name,
                            'amount' => $form->amount,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        $total += $form->amount;
                    }
                }


                $totalWorkDay = 26;
                $dailyAmount = $total / $totalWorkDay;

                $notWorking = $totalWorkDay - $attendance?->total;
                $deduction = $notWorking * $dailyAmount;
                if ($notWorking > 0 && $deduction > 0) {
                    $total -= $deduction;
                    $details[] = [
                        'payslip_id' => $payslip->id,
                        'name' => "Tidak masuk $notWorking hari",
                        'amount' => -$deduction,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if ($attendance?->penalty && $attendance?->penalty > 0) {
                    $total -= $attendance?->penalty;
                    $details[] = [
                        'payslip_id' => $payslip->id,
                        'name' => "Terlambat $attendance?->in_minutes menit",
                        'amount' => -$attendance?->penalty,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (count($formDeductionDetails) > 0) {
                    $total += $formDeduction;
                    $details = array_merge($details, $formDeductionDetails);
                }


                $payslip->update(['total' => $total]);
                $payslip->details()->insert($details);
            }


            Attendance::where('is_paid', 0)->update(['is_paid' => 1]);
            EmployeeForm::where('is_paid', 0)->update(['is_paid' => 1]);
        });

        return redirect()->back();
    }

    public function export(Request $request)
    {
        $payrolls = Payroll::orderBy('date', 'desc')->selectRaw("id, CONCAT(name,' ',DATE_FORMAT(date,'%d/%m/%Y')) as name")->get();
        $target = $request->target ? AppHelper::unObfuscate($request->target) : $payrolls->first()?->id;

        $selected = $payrolls->where('id', $target)->first();
        $filename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $selected->name);
        $filename = trim($filename, '_');

        return Excel::download(new PayslipExport($target), "$filename.xlsx");
    }
}
