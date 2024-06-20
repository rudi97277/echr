<?php

namespace App\View\Components;

use App\Helpers\AppHelper;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CustomTable extends Component
{
    /**
     * Create a new component instance.
     */
    public $currentId, $pagination;
    public function __construct(
        public $headers,
        public $source,
        $pagination
    ) {
        $this->pagination = $pagination;
    }

    public function setCurrentId($id)
    {
        $this->currentId = AppHelper::obfuscate($id);
    }

    public function getCurrentId()
    {
        return $this->currentId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.custom-table');
    }
}
