<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class course extends Component
{
    public $name;
    public $code;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.course');
    }
}
