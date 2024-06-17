<?php

namespace App\Http\Resources;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PositionResource extends JsonResource
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
            'employee' => $this->employee,
            'salary' => AppHelper::formatRupiah($this->salary),

        ];
    }
}
