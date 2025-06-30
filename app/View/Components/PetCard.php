<?php

namespace App\View\Components;

use App\Models\Pet;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PetCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Pet $pet)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pet-card');
    }
}
