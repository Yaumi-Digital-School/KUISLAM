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
    public function __construct($titlePage)
    {
        $this->titlePage = $titlePage;
    }

    public function render()
    {
        return view('layouts.main');
    }
}
