<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::all();
        return view('recipes.index', compact('recipes'));
    }

    public function create()
    {
        return view('recipes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Name' => 'required|string|max:255',
            'Instructions' => 'required',
            'Time' => 'nullable|integer',
            'Image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('Image')) {
            $path = $request->file('Image')->store('recipes', 'public');
            $validated['Image'] = basename($path);
        }

        $validated['UserID'] = Auth::id();
        Recipe::create($validated);

        return redirect()->route('recipes.index')->with('success', 'Recipe created!');
    }

    public function show(Recipe $recipe)
    {
        return view('recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe)
    {
        return view('recipes.edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'Name' => 'required|string|max:255',
            'Instructions' => 'required',
            'Time' => 'nullable|integer',
            'Image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('Image')) {
            $path = $request->file('Image')->store('recipes', 'public');
            $validated['Image'] = basename($path);
        }

        $recipe->update($validated);

        return redirect()->route('recipes.show', $recipe);
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        return redirect()->route('recipes.index')->with('success', 'Recipe deleted!');
    }
}
