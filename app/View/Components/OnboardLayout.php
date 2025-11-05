<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class OnboardLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public $pageTitle;
    public $loginMessage;
    public $showBackButton;
    public $title;
    public $width;
    public $backUrl;
    public $showSkipButton;

    public function __construct($pageTitle = null, $loginMessage = null, $showBackButton = false, $title = null, $width = null, $backUrl = null, $showSkipButton = null)
    {
        $this->pageTitle = $pageTitle;
        $this->loginMessage = $loginMessage;
        $this->showBackButton = $showBackButton;
        $this->title = $title;
        $this->width = $width;
        $this->backUrl = $backUrl;
        $this->showSkipButton = $showSkipButton;
    }

    public function render(): View
    {
        return view('layouts.onboard');
    }
}
