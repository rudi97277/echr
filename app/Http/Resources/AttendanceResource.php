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
        $penalty = "<span class='bg-complement text-xs text-white rounded-md p-1'>Tepat Waktu</span>";
        if ($this->attendancePenalty) {
            $pen = $this->attendancePenalty;
            $amount = AppHelper::formatRupiah($pen->amount);
            $penalty = "<span class='text-white bg-danger whitespace-nowrap text-xs text-center p-1 rounded-md'>Telat {$pen->in_minutes} menit
                     $amount</span>";
        }
        Carbon::setLocale('id');
        return [
            'date' => Carbon::parse($this->date)->isoFormat('dddd, DD MMMM YYYY'),
            'in_at' => $this->in_at,
            'in_image' => $this->in_image,
            'pinalty' => $penalty,
            'out_at' => $this->out_at,
            'out_image' => $this->out_image,
        ];
    }
}
