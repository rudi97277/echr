<?php

namespace App\Http\Controllers\Web\Admin;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\MasterFormResource;
use App\Models\Form;
use App\Models\FormComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;

class MasterFormController extends Controller
{
    public function index(Request $request)
    {
        $headers = [
            'name',
            'harga',
            'komponen'
        ];

        $forms = Form::withCount('details as component')
            ->when($request->keyword, fn ($query) => $query->where('name', 'LIKE', "%$request->keyword%"))
            ->paginate($request->input('page_size', 10));

        return view('layouts.admin.master-form', [
            'headers' => $headers,
            'pagination' => AppHelper::paginationData($forms),
            'forms' => MasterFormResource::collection($forms)
        ]);
    }

    public function create()
    {
        $components = [];

        $formComponents = FormComponent::select('code as id', 'name', 'component')
            ->get()->map(function ($detail) use (&$components) {
                $components[] = Blade::render("<{$detail->component} name='{$detail->id}' text='{$detail->name}' />");
                unset($detail->component);
                return $detail;
            });

        return view('layouts.admin.master-form-create', [
            'formComponents' => $formComponents,
            'components' => $components
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "components" => "required|array|min:1",
            "name" => "required|string",
            "amount" => "required|numeric"
        ], [
            "components.required" => "Pilih paling sedikit 1 komponen form",
            "name.required" => "Nama form dibutuhkan",
            "amount.required" => "Harga form dibutuhkan",
            "components.min" => "Pilih paling sedikit 1 komponen form"
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $form = Form::create([
            'name' => $request->name,
            'amount' => $request->amount
        ]);

        $components = collect($request->components)->map(fn ($item) => [
            'form_id' => $form->id,
            'component_code' => AppHelper::unObfuscate($item)
        ])->toArray();
        $form->details()->insert($components);

        return redirect()->route('admin.master-form.edit', [AppHelper::obfuscate($form->id)])
            ->with('success', 'Form berhasil ditambahkan.');;
    }

    public function show(Request $request, string $obfuscatedId)
    {
        $formId = AppHelper::unObfuscate($obfuscatedId);

        $form = Form::where('id', $formId)
            ->with([
                'details' => fn ($query) =>
                $query->join('form_components as fc', 'fc.code', 'form_details.component_code')
                    ->select('id', 'form_id', 'name', 'code', 'component')
            ])
            ->firstOrFail();

        $components = [];
        $codes = [];
        $details = [];
        foreach ($form->details as $detail) {
            $codes[] = $detail->code;
            $details[$detail->code] = true;
            $components[] = Blade::render("<{$detail->component} name='{$detail->code}' text='{$detail->name}' />");
        }

        $formComponents = FormComponent::select('code as id', 'name')
            ->get()->map(function ($comp) use ($details) {
                $comp->id_exists = isset($details[$comp->id]);
                return $comp;
            });

        return view('layouts.admin.master-form-edit', [
            'formName' => $form->name,
            'formAmount' => $form->amount,
            'components' => $components,
            'formComponents' => $formComponents,
        ]);
    }

    public function update(Request $request, string $obfuscatedId)
    {
        $validator = Validator::make($request->all(), [
            "components" => "required|array|min:1",
            "name" => "required|string",
            "amount" => "required|numeric"
        ], [
            "components.required" => "Pilih paling sedikit 1 komponen form",
            "name.required" => "Nama form dibutuhkan",
            "amount.required" => "Harga form dibutuhkan",
            "components.min" => "Pilih paling sedikit 1 komponen form"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $formId = AppHelper::unObfuscate($obfuscatedId);
        $components = collect($request->components)->map(fn ($item) => [
            'form_id' => $formId,
            'component_code' => AppHelper::unObfuscate($item)
        ])->toArray();

        $form = Form::where('id', $formId)->firstOrFail();

        $form->update(['name' => $request->name, 'amount' => $request->amount]);
        $form->details()->delete();
        $form->details()->insert($components);

        return redirect()->back()->with('success', 'Update komponen form berhasil.');
    }
}
