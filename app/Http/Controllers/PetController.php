<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PetController extends Controller
{
    public function index(): View
    {
        $pets = Pet::paginate(15); // 15 pets per page
        return view('pets.index', compact('pets'));
    }

    public function create(): View
    {
        if (Auth::user()->role !== 'lister') {
            abort(403, 'Unauthorized action.');
        }
        return view('pets.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isLister()) {
            abort(403, 'Unauthorized action.');
        }
        // Logic to store a new pet in the database
        $data = $request->validate([
            'name' => ['required'],
            'species' => ['required', 'string', 'max:255'],
            'breed' => ['nullable', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'gender' => ['nullable', 'in:male,female,unknown'],
        ]);

        $data['user_id'] = Auth::id(); // Assuming the user is authenticated

        Pet::create($data);

        return redirect()->route('pets.index')->with('success', 'Pet created successfully.');
    }
}
