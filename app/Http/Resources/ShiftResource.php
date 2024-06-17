<?php

namespace App\Http\Resources;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShiftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'clock_in' => $this->clock_in,
            'clock_out' => $this->clock_out,
            'penalty_per_minutes' => AppHelper::formatRupiah($this->penalty_per_minutes, false),
            'employees' => $this->employees_count
        ];
    }
}
