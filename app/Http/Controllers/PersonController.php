<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Person;

class PersonController extends Controller
{

    // Get all people
    public function index()
    {
        $people = Person::with('creator')->get();
        return view('people.index', compact('people'));
    }

    // Get peopleId with his children and his parents
    public function show($id)
    {
        $person = Person::with(['children', 'parents'])->findOrFail($id);
        return view('people.show', compact('person'));
    }

    //created new User
    public function create()
    {
        //return "hello";
        return view('people.create');
    }

    public function store(Request $request)
    {
        // Validate the data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_names' => 'nullable|string|max:255',
            'birth_name' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ]);

        $validated['first_name'] = ucfirst(strtolower($validated['first_name']));
        $validated['last_name'] = strtoupper($validated['last_name']);

        $validated['birth_name'] = isset($validated['birth_name']) && $validated['birth_name']
        ? strtoupper($validated['birth_name'])
        : strtoupper($validated['last_name']);

        $validated['middle_names'] = isset($validated['middle_names']) && $validated['middle_names']
        ? collect(explode(',', $validated['middle_names']))
            ->map(fn($name) => ucfirst(strtolower(trim($name))))
            ->implode(', ')
        : null;

        $validated['date_of_birth'] = $validated['date_of_birth'] ?? null;

        $validated['created_by'] = auth()->id();
        try {
            //created new user in BDD
            Person::create($validated);

            // Redirect the user to the list of people with a success message
            return redirect()->route('people.index')->with('success', 'Personne créée avec succès.');
            } catch (\Exception $e) {
                //message d'erreur
                return redirect()->route('people.create')->with('error', 'Une erreur est survenue lors de la création de la personne.');
            }
    }

}
