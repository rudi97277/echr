<?php

namespace App\Http\Resources;

use App\Helpers\AppHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayslipResource extends JsonResource
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
            'name' => $this->name,
            'total' => AppHelper::formatRupiah($this->total),
            'workday' => $this->workday,
            'date' => Carbon::parse($this->date)->isoFormat('dddd, DD MMMM YYYY')
        ];
    }
}
