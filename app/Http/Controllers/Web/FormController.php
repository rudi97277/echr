<?php

namespace App\Http\Controllers\Web;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeFormResource;
use App\Models\EmployeeForm;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    public function page(Request $request)
    {
        $headers = [
            'teknisi',
            'form',
            'tanggal pembuatan',
            'pendapatan'
        ];

        $forms = EmployeeForm::leftJoin('employees as e', 'e.id', 'employee_forms.employee_id')
            ->join('forms as f', 'f.id', 'employee_forms.form_id')
            ->select(
                'employee_forms.id',
                'e.name as employee_name',
                'f.name as form',
                'employee_forms.created_at',
                'employee_forms.amount'
            )
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
        ]);
    }

    public function pageEditAction(Request $request, string $obfuscatedId)
    {
        $employeeFormId = AppHelper::unObfuscate($obfuscatedId);
        $content = json_encode($request->all());
        EmployeeForm::where('id', $employeeFormId)->update(['content' => $content]);

        return redirect()->route('admin.form');
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

        $employeeId = $request->employee ?  AppHelper::unObfuscate($request->employee) : null;
        $formId = AppHelper::unObfuscate($request->target);
        $form = Form::where('id', $formId)->firstOrFail();

        EmployeeForm::create([
            'employee_id' => $employeeId,
            'form_id' => $formId,
            'amount' => $form->amount,
            'content' => json_encode($request->all())
        ]);

        return redirect()->route('admin.form');
    }
}
