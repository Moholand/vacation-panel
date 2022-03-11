<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatusFilter extends Component
{
    public $statuses;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Array $statuses)
    {
        $this->statuses = $statuses;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.status-filter');
    }
}
