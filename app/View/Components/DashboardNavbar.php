<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardNavbar extends Component
{
    public array $links = [
        [
            'name' => 'Dashboard',
            'route' => 'dashboard.index',
            'icon' => 'heroicon-o-home',
            'activeIcon' => 'heroicon-s-home',
        ],
        [
            'name' => 'Pets',
            'route' => 'dashboard.pets',
            'icon' => 'ionicon-paw-outline',
            'activeIcon' => 'ionicon-paw'
        ],
        [
            'name' => 'Adoptions Requests',
            'route' => 'home',
            'icon' => 'heroicon-o-heart',
            'activeIcon' => 'heroicon-s-heart',
        ],
    ];
    /**
     * Create a new component instance.
     */
    public function __construct(public string $title = 'Dashboard')
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard-navbar');
    }
}
