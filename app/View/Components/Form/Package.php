<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Package extends Component
{

    public $packages;
    public function __construct()
    {
        $this->packages = [
            [
                'name' => 'Rp 165.000 / 5 Mbps',
                'value' => '5mbps165rb',
            ],
            [
                'name' => 'Rp 200.000 / 10 Mbps',
                'value' => '10mbps200rb',
            ],
            [
                'name' => 'Rp 250.000 / 15 Mbps',
                'value' => '15mbps250rb',
            ]
        ];
    }


    public function render(): View|Closure|string
    {
        return view('components.form.package');
    }
}
