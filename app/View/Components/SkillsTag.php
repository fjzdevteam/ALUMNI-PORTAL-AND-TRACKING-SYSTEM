<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SkillsTag extends Component
{
    public $color;

    public function __construct($color = 'green')
    {
        $this->color = $color;
    }

    public function render()
    {
        return view('components.skills-tag');
    }
}
