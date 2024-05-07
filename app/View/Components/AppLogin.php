<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLogin extends Component
{
    public $title;
    public $styles = null;
    public $scripts = null;
    public function __construct($title = null)
    {
        $this->title = $title ?? 'Sung';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.login');
    }
}
