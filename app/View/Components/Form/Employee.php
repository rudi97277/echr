<?php

namespace App\View\Components\Form;

use App\Models\Employee as ModelsEmployee;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Employee extends Component
{
    public $employees;
    public function __construct()
    {
        $this->employees = ModelsEmployee::select('id', 'name')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.employee');
    }
}
