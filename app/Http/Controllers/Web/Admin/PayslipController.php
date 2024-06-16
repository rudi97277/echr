<?php

namespace App\Http\Controllers\Web\Admin;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PayslipDetailResource;
use App\Http\Resources\PayslipResource;
use App\Models\Payroll;
use App\Models\Payslip;
use App\Models\PayslipDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PayslipController extends Controller
{
    public function page(Request $request)
    {
        $headers = [
            'Karyawan',
            'Total',
            'Hari Kerja',
            'Tanggal'
        ];

        $payrolls = Payroll::orderBy('date', 'desc')->select('id', 'name', 'date')->get();

        $target = $request->target ? AppHelper::unObfuscate($request->target) : $payrolls->first()?->id;

        $payslips = Payslip::join('employees as e', 'e.id', 'payslips.employee_id')
            ->select('payslips.id', 'e.name', 'total', 'workday', 'payslips.created_at')
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

    public function pageEdit(Request $request, string $obfuscatedId)
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

    public function createPayslip(Request $request)
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

        $date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');

        Payroll::create([
            'name' => $request->name,
            'date' => $date
        ]);

        return redirect()->back();
    }
}
