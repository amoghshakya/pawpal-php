<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use App\Models\Pet;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use function Laravel\Prompts\search;

class PetController extends Controller
{
    public function index(): View
    {
        $pets = Pet::orderBy('created_at', 'desc')
            ->with(['lister', 'images', 'adoptionApplications'])
            ->simplePaginate(10); // 10 pets per page
        return view('pets.index', compact('pets'));
    }

    public function show(Pet $pet): View
    {
        return view('pets.show', ['pet' => $pet]);
    }

    public function create(): View
    {
        return view('pets.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if (!Auth::user()->isLister()) {
            abort(403, 'Unauthorized action.');
        }
        // Logic to store a new pet in the database
        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'species' => ['required', 'string', 'max:255', 'min:3'],
            'breed' => ['nullable', 'string', 'max:255'],
            'age' => ['required', 'string', 'min:5'],
            'description' => ['nullable', 'string'],
            'gender' => ['nullable', 'in:male,female,unknown'],
            'vaccinated' => ['required', 'in:true,false,1,0'],
            'vaccination_details' => ['nullable', 'string'],
            'special_needs' => ['nullable', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'photos' => ['required', 'array'],
            'photos.*' => ['file', 'image', 'max:10240', 'mimes:png,jpg,jpeg'],
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

    public function edit(Pet $pet): View
    {
        return view('pets.edit', ['pet' => $pet]);
    }

    /**
     * Update the specified pet in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pet  $pet
     * @return \Illuminate\Http\RedirectResponse
     * 
     * This method expects a Request object containing the create pet data
     * along with some extra fields for updating and deleting photos.
     * 
     * `delete_photos` is an array of photo IDs to be deleted.
     * `update_captions` is a JSON string containing updated captions for the photos.
     * 
     * The `update_captions` JSON is structured as follows:
     * {
     * "existing-<id>": "New caption for photo with ID <id>",
     * }
     */
    public function update(Request $request, Pet $pet)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'species' => ['required', 'string', 'max:255', 'min:3'],
            'breed' => ['nullable', 'string', 'max:255'],
            'age' => ['required', 'string', 'min:5'],
            'description' => ['nullable', 'string'],
            'gender' => ['nullable', 'in:male,female,unknown'],
            'vaccinated' => ['required', 'in:true,false,1,0'],
            'vaccination_details' => ['nullable', 'string'],
            'special_needs' => ['nullable', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'photos' => ['nullable', 'array'], // this can be empty for edits
            'photos.*' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:10240'], // max 10MB
            // Deleting photos: array of numeric IDs, optional
            'delete_photos' => ['nullable', 'array'],
            'delete_photos.*' => ['integer', 'exists:pet_images,id'],
            'captions_json' => ['nullable', 'json'],
            'update_captions' => ['nullable', 'array'],
        ]);

        $pet->update([
            'name' => $data['name'],
            'species' => $data['species'],
            'breed' => $data['breed'] ?? null,
            'age' => $data['age'],
            'gender' => $data['gender'] ?? 'unknown',
            'status' => 'available', // Default status
            'description' => $data['description'],
            'vaccinated' => $data['vaccinated'] === 'true' || $data['vaccinated'] === '1',
            'vaccination_details' => $data['vaccinated'] === 'true' || $data['vaccinated'] === '1' ? $data['vaccination_details'] : null,
            'special_needs' => $data['special_needs'] ?? null,
            'location' => $data['location'],
        ]);

        // Delete specified photos
        if ($request->filled('delete_photos')) {
            foreach ($request->delete_photos as $photoId) {
                $photo = $pet->images()->find($photoId);
                if ($photo) {
                    Storage::delete('public/' . $photo->image_path);
                    $photo->delete();
                }
            }
        }

        if ($request->has('update_captions')) {
            foreach ($request->update_captions as $key => $caption) {
                // we expect key like 'existing-2'
                if (Str::startsWith($key, 'existing-')) {
                    $id = Str::after($key, 'existing-');
                    $image = $pet->images()->find($id);
                    if ($image) {
                        $image->caption = $caption;
                        $image->save();
                    }
                }
            }
        }

        if ($request->hasFile('photos')) {
            $captions = json_decode($request->captions_json ?? '{}', true);

            foreach ($request->file('photos') as $index => $file) {
                $path = $file->store('pets', 'public');
                $key = $file->getClientOriginalName() . '-' . $file->getSize();

                $pet->images()->create([
                    'image_path' => $path,
                    'caption' => $captions[$key] ?? null,
                ]);
            }
        }

        return redirect()->route('pets.show', $pet)->with('success', 'Pet updated successfully!');
    }

    public function destroy(Pet $pet): RedirectResponse
    {
        $pet->delete();

        return redirect()->route('dashboard.pets')->with('success', 'Pet deleted successfully.');
    }

    public function apply(Pet $pet): View
    {
        return view('pets.apply', ['pet' => $pet]);
    }

    public function applyStore(Request $request, Pet $pet): RedirectResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'min:50', 'max:1000'],
            'other_pets' => ['required', 'in:true,false,1,0'],
            'other_pets_details' => ['nullable', 'string', 'min:50', 'max:1000'],
            'living_conditions' => ['required', 'string', 'min:50', 'max:1000'],
        ]);
        $data['user_id'] = Auth::id();
        $data['pet_id'] = $pet->id;
        $data['status'] = 'pending';

        $application = AdoptionApplication::create($data);

        return redirect()->route('pets.show', $pet)
            ->with('success', 'Application submitted successfully.');
    }

    public function updateStatus(Request $request, Pet $pet): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:available,adopted'],
        ]);

        $pet->update([
            'status' => $data['status'],
        ]);

        return redirect()->route('pets.update', $pet);
    }

    // AJAX search for the dashboard pets table
    public function searchDashboard(Request $request)
    {
        if (!$request->ajax()) {
            abort(403, 'Unauthorized action.');
        }
        $query = Pet::where('user_id', Auth::id());

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('species', 'like', "%{$search}%")
                    ->orWhere('breed', 'like', "%{$search}%");
            });
        }

        $pets = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('components.table', [
            'headers' => ['name', 'species', 'breed', 'created_at', 'updated_at', 'status'],
            'rows' => $pets,
            'actionsSlot' => fn($pet) => view('components.partials.table-actions', ['id' => $pet->id])
        ])->render();
    }
}
