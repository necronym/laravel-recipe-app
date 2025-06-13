<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use App\Models\CategoryType;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{

    public function index(Request $request)
    {
        $query = Recipe::with('ratings');

        if ($request->filled('time')) {
            switch ($request->time) {
                case '0-10': $query->where('Time', '<=', 10); break;
                case '10-20': $query->whereBetween('Time', [11, 20]); break;
                case '20-40': $query->whereBetween('Time', [21, 40]); break;
                case '40-60': $query->whereBetween('Time', [41, 60]); break;
                case '60+': $query->where('Time', '>', 60); break;
            }
        }

        if ($request->filled('categories')) {
            // Flatten nested arrays into a flat array of IDs
            $categoryIDs = collect($request->categories)->flatten()->all();

            $query->whereHas('categories', function ($q) use ($categoryIDs) {
                $q->whereIn('categories.CategoryID', $categoryIDs);
            });
        }

        if ($request->filled('ingredients')) {
            $query->whereHas('ingredients', function ($q) use ($request) {
                $q->whereIn('ingredients.IngredientID', $request->ingredients);
            });
        }

        return view('recipes.index', [
            'recipes' => $query->paginate(12),
            'categoryTypes' => CategoryType::with('categories')->get(),
            'ingredients' => Ingredient::all(),
            'selectedCategories' => $request->categories ?? [],
            'selectedIngredients' => $request->ingredients ?? [],
            'selectedTime' => $request->time ?? '',
        ]);
    }

    public function create()
    {
        return view('recipes.create', [
            'categoryTypes' => CategoryType::with('categories')->get(),
            'ingredients' => Ingredient::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Name' => 'required|string|max:255',
            'Instructions' => 'required',
            'Time' => 'nullable|integer|min:0',
            'Image' => 'nullable|image|max:2048',
            'categories' => 'nullable|array',
            'ingredients' => 'nullable|array',
        ]);

        if ($request->hasFile('Image')) {
            $path = $request->file('Image')->store('recipes', 'public');
            $validated['Image'] = basename($path);
        }

        $validated['UserID'] = Auth::id();
        $recipe = Recipe::create($validated);

        // Sync categories
        if ($request->has('categories')) {
            $recipe->categories()->sync($request->categories);
        }

        // Sync ingredients
        if ($request->has('ingredients')) {
            $recipe->ingredients()->sync($request->ingredients);
        }

        return redirect()->route('recipes.index')->with('success', 'Recipe created!');
    }

    public function show(Recipe $recipe)
    {
        $comments = $recipe->comments()->with('user')->paginate(5);

        return view('recipes.show', [
            'recipe' => $recipe,
            'comments' => $comments,
        ]);
    }


    public function edit(Recipe $recipe)
    {
        return view('recipes.edit', [
            'recipe' => $recipe,
            'categoryTypes' => CategoryType::with('categories')->get(),
            'ingredients' => Ingredient::all(),
            'selectedCategories' => $recipe->categories->pluck('CategoryID')->toArray(),
            'selectedIngredients' => $recipe->ingredients->pluck('IngredientID')->toArray()
        ]);
    }

    public function update(Request $request, Recipe $recipe)
    {
        $validated = $request->validate([
            'Name' => 'required|string|max:255',
            'Instructions' => 'required',
            'Time' => 'nullable|integer|min:0',
            'Image' => 'nullable|image|max:2048',
            'categories' => 'nullable|array',
            'ingredients' => 'nullable|array',
        ]);

        if ($request->hasFile('Image')) {
            $path = $request->file('Image')->store('recipes', 'public');
            $validated['Image'] = basename($path);
        }

        $recipe->update($validated);

        // This ensures empty arrays are used if no items are selected
        $recipe->categories()->sync($request->input('categories', []));
        $recipe->ingredients()->sync($request->input('ingredients', []));

        return redirect()->route('recipes.show', $recipe)->with('success', 'Recipe updated!');
    }

    public function destroy(Recipe $recipe)
    {
        // Detach categories & ingredients (pivot tables)
        $recipe->categories()->detach();
        $recipe->ingredients()->detach();

        // Delete related comments
        $recipe->comments()->delete();

        // Delete related ratings
        $recipe->ratings()->delete();

        // Finally, delete the recipe
        $recipe->delete();

        return redirect()->route('recipes.index')->with('success', 'Recipe deleted!');
    }

}
