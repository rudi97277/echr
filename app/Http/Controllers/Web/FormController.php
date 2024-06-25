<?php

namespace App\Http\Controllers\Web;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeFormResource;
use App\Models\EmployeeForm;
use App\Models\Form;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    public function page(Request $request)
    {
        $headers = [
            'karyawan',
            'form',
            'tanggal',
            'pendapatan'
        ];

        $forms = EmployeeForm::leftJoin('employees as e', 'e.id', 'employee_forms.employee_id')
            ->join('forms as f', 'f.id', 'employee_forms.form_id')
            ->select(
                'employee_forms.id',
                'e.name as employee_name',
                'f.name as form',
                'employee_forms.date',
                'employee_forms.amount'
            )
            ->orderBy('employee_forms.date', 'desc')
            ->paginate($request->input('page_size', 10));

        $formType = Form::get();

        return view('layouts.admin.form', [
            'headers' => $headers,
            'forms' => EmployeeFormResource::collection($forms),
            'formType' => $formType,
            'pagination' => AppHelper::paginationData($forms)
        ]);
    }

    public function pageEdit(Request $request, string $obfuscatedId)
    {
        $employeeFormId = AppHelper::unObfuscate($obfuscatedId);
        $employeeForm = EmployeeForm::where('id', $employeeFormId)
            ->with(['details.component', 'form'])->firstOrFail();
        $details = $employeeForm->details;
        $content = json_decode($employeeForm->content, true);
        $components = [];

        foreach ($details as $item) {
            $component = $item->component;
            $value = $content[$component->code] ?? '';
            $components[] =  Blade::render("<{$component->component} value='$value' name='{$component->code}' text='{$component->name}' />");
        }

        return view('layouts.admin.form-layout', [
            'components' => $components,
            'formName' => $employeeForm?->form?->name,
            'formAmount' => $employeeForm?->amount
        ]);
    }

    public function pageEditAction(Request $request, string $obfuscatedId)
    {
        $employeeFormId = AppHelper::unObfuscate($obfuscatedId);
        $amount = $request->amount ?? 0;
        $content = json_encode($request->all());
        $date = $request->_1date ? Carbon::createFromFormat('d/m/Y', $request->_1date)->format('Y-m-d') : date('Y-m-d');
        EmployeeForm::where('id', $employeeFormId)->update(['content' => $content, 'date' => $date, 'amount' => $amount]);

        return redirect()->route('admin.form')->with(['success' => 'Form berhasil di edit!']);
    }

    public function pageAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "target" => "required|string",
        ], [
            "target.required" => "Target form diperlukan",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $formId = AppHelper::unObfuscate($request->target);
        $form = Form::where('id', $formId)->with('details.component')->firstOrFail();
        $details = $form->details;
        $components = [];

        foreach ($details as $item) {
            $component = $item->component;
            $components[] =  Blade::render("<{$component->component} name='{$component->code}' text='{$component->name}' />");
        }

        return view('layouts.admin.form-layout', [
            'components' => $components,
            'formName' => $form->name,
            'formAmount' => $form->amount
        ]);
    }

    public function pageAddAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "target" => "required|string",
        ], [
            "target.required" => "Target form diperlukan",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $employeeId = $request->_2employee ?  AppHelper::unObfuscate($request->_2employee) : null;
        $formId = AppHelper::unObfuscate($request->target);
        $form = Form::where('id', $formId)->firstOrFail();

        $date = $request->_1date ? Carbon::createFromFormat('d/m/Y', $request->_1date)->format('Y-m-d') : date('Y-m-d');

        EmployeeForm::create([
            'employee_id' => $employeeId,
            'form_id' => $formId,
            'amount' => $request->amount ?? $form->amount,
            'date' => $date,
            'content' => json_encode($request->all())
        ]);

        return redirect()->route('admin.form');
    }

    public function deleteAction(Request $request, string $obfuscatedId)
    {
        $employeeFormId = AppHelper::unObfuscate($obfuscatedId);
        EmployeeForm::where('id', $employeeFormId)->delete();
        return redirect()->route('admin.form')->with(['success' => 'Form berhasil di hapus!']);
    }
}
