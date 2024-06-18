<?php

namespace App\Http\Controllers\Web;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PayslipResource;
use App\Models\Payslip;
use App\Models\PayslipDetail;
use App\Traits\EmployeeInfo;
use Illuminate\Http\Request;

class PayslipController extends Controller
{
    use EmployeeInfo;
    public function index(Request $request)
    {
        $employeeId = $this->getCurrentEmployeeId();
        $payslips = Payslip::where('employee_id', $employeeId)
            ->join('payrolls as p', 'p.id', 'payslips.payroll_id')
            ->selectRaw("payslips.id,workday,name,date,total")
            ->orderBy('date', 'desc')
            ->get();

        return view('layouts.worker.payslip', [
            'payslips' => PayslipResource::collection($payslips)->toArray($request)
        ]);
    }

    public function show(string $obfuscatedId)
    {
        $payslipId = AppHelper::unObfuscate($obfuscatedId);
        $payslip = Payslip::where('id', $payslipId)
            ->with([
                'details:payslip_id,name,amount',
                'employee' => fn ($query) => $query->join('positions as p', 'p.id', 'employees.position_id')
                    ->select('employees.id', 'employees.name', 'p.name as position')
            ])
            ->firstOrFail();

        return view('layouts.worker.payslip-detail', [
            'details' => $payslip->details,
            'employee' => $payslip->employee,
            'total' => $payslip->total,
            'workday' => $payslip->workday
        ]);
    }
}
