<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PetController extends Controller
{
    public function index(): View
    {
        $pets = Pet::with(['lister', 'images'])->simplePaginate(10); // 10 pets per page
        return view('pets.index', compact('pets'));
    }

    public function show(int $id): View
    {
        $pet = Pet::with(['lister', 'images'])->findOrFail($id);
        return view('pets.show', ['pet' => $pet]);
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
            'age' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'gender' => ['nullable', 'in:male,female,unknown'],
            'vaccinated' => ['required', 'in:true,false,1,0'],
            'vaccination_details' => ['nullable', 'string'],
            'special_needs' => ['nullable', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'photos' => ['required', 'array'],
            'photos.*' => ['file', 'image', 'max:10240'],
            'captions_json' => ['nullable', 'json'],
        ]);

        // dd($data);

        $captions = [];
        if ($request->filled('captions_json')) {
            $captions = json_decode($request->input('captions_json'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors(['captions_json' => 'Invalid JSON format for captions']);
            }
        }

        $data['user_id'] = Auth::user()->id; // Assuming the user is authenticated

        $pet = Pet::create([
            'user_id' => $data['user_id'],
            'name' => $data['name'],
            'species' => $data['species'],
            'breed' => $data['breed'] ?? null,
            'age' => $data['age'],
            'gender' => $data['gender'] ?? 'unknown',
            'status' => 'available', // Default status
            'description' => $data['description'],
            'vaccinated' => $data['vaccinated'] === 'true' || $data['vaccinated'] === '1',
            'vaccination_details' => $data['vaccination_details'] ?? null,
            'special_needs' => $data['special_needs'] ?? null,
            'location' => $data['location'],
        ]);

        foreach ($request->file('photos') as $index => $photo) {
            $filename = $photo->store('pets/' . $pet->id, 'public'); // /public/pets/{pet_id}
            $key = $photo->getClientOriginalName() . '-' . $photo->getSize();

            $caption = $captions[$key] ?? null;

            $pet->images()->create([
                'image_path' => $filename,
                'caption' => $caption,
            ]);
        }

        return redirect()->route('pets.index')->with('success', 'Pet created successfully.');
    }
}
