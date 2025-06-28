<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PetController extends Controller
{
    public function index(): View
    {
        $pets = Pet::with(['lister'])->simplePaginate(10); // 10 pets per page
        return view('pets.index', compact('pets'));
    }

    public function show(int $id): View
    {
        $pet = Pet::with(['lister'])->findOrFail($id);
        return dd('Pet details', $pet);
    }

    public function create(): View
    {
        if (!Auth::user()->isLister()) {
            abort(403, 'Unauthorized action.');
        }
        return view('pets.create');
    }

    public function store(Request $request): RedirectResponse
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

        $data['user_id'] = Auth::user()->id; // Assuming the user is authenticated

        Pet::create($data);

        return redirect()->route('pets.index')->with('success', 'Pet created successfully.');
    }
}
