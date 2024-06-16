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
    public function page(Request $request)
    {
        $employeeId = $this->getCurrentEmployeeId();
        $payslips = Payslip::where('employee_id', $employeeId)
            ->join('payrolls as p', 'p.id', 'payslips.payroll_id')
            ->selectRaw("payslips.id,workday,name,date,total")
            ->get();

        return view('layouts.worker.payslip', [
            'payslips' => PayslipResource::collection($payslips)->toArray($request)
        ]);
    }

    public function pageDetail(string $obfuscatedId)
    {
        $payslipId = AppHelper::unObfuscate($obfuscatedId);
        $details = PayslipDetail::where('payslip_id', $payslipId)->select('name', 'amount')->get();
        return view('layouts.worker.payslip-detail', [
            'details' => $details
        ]);
    }
}
