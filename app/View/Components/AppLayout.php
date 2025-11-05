<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public $navType;
    public $title;

    public function __construct($title = 'My Page', $navType = 'alumni')
    {
        $this->navType = $navType;
        $this->title = $title;
    }

    public function render()
    {
        return view('layouts.app');
    }
}
