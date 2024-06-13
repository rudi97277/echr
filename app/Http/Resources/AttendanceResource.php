<?php

namespace App\Http\Resources;

use App\Helpers\AppHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $penalty = "";
        if ($this->attendancePenalty) {
            $pen = $this->attendancePenalty;
            $amount = AppHelper::formatRupiah($pen->amount);
            $penalty = "<p class='text-danger'> {$pen->in_minutes} menit
                    - $amount</p>";
        }
        Carbon::setLocale('id');
        return [
            'date' => Carbon::parse($this->date)->isoFormat('dddd, DD MMMM YYYY'),
            'in_at' => $this->in_at,
            'pinalty' => $penalty,
            'in_image' => $this->in_image,
            'out_at' => $this->out_at,
            'out_image' => $this->out_image,
        ];
    }
}
