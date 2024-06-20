<?php

namespace App\Http\Resources;

use App\Helpers\AppHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        Carbon::setLocale('id');
        return [
            'id' => $this->id,
            'employee' => $this->employee_name,
            'form' => $this->form,
            'tanggal' => Carbon::parse($this->date)->isoFormat('dddd, DD MMMM YYYY'),
            'amount' => AppHelper::formatRupiah($this->amount),
        ];
    }
}
