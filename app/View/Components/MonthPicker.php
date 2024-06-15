<?php

namespace App\View\Components;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MonthPicker extends Component
{
    /**
     * Create a new component instance.
     */
    public $months;
    public $years;
    public function __construct()
    {
        Carbon::setLocale('id');
        for ($month = 1; $month <= 12; $month++) {
            $this->months[] = [
                'name' => Carbon::parse("2024-$month-1")->isoFormat('MMMM'),
                'value' => str_pad($month, 2, 0, STR_PAD_LEFT)
            ];
        }
        $startDevelopment = 2024;
        $startYear = $startDevelopment;
        $endYear = $startYear + 50;
        for ($startYear; $startYear < $endYear; $startYear++) {
            $this->years[] = $startYear;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.month-picker');
    }
}
