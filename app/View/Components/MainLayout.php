<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MainLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */

    public $titlePage;
    public $themePage;
    public function __construct($titlePage, $themePage="green")
    {
        $this->titlePage = $titlePage;
        $this->themePage = $themePage;
    }

    public function render()
    {
        return view('layouts.main');
    }
}
