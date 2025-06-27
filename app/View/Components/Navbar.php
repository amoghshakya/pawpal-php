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
            'pets' => ['route' => 'pets.index', 'label' => 'Pets'],
            'about' => ['route' => 'home', 'label' => 'About'],
            'contact' => ['route' => 'home', 'label' => 'Contact'],
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
