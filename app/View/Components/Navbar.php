<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    public array $navlinks;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->navlinks = [
            'home' => ['route' => 'home', 'label' => 'Home'],
            'pets' => ['route' => 'pets.index', 'label' => 'Pets'],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar');
    }
}
