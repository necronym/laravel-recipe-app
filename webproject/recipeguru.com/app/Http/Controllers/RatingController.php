<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    // Store or update a rating
    public function store(Request $request, $recipe)
    {
        $request->validate([
            'Score' => 'required|integer|min:1|max:5',
        ]);

        Rating::updateOrCreate(
            [
                'UserID' => Auth::id(),
                'RecipeID' => $recipe,
            ],
            ['Score' => $request->Score]
        );

        return back()->with('success', 'Rating submitted.');
    }

    // Delete a rating
    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);
        $user = Auth::user();

        if ($user->id !== $rating->UserID && $user->RoleID !== 1) {
            abort(403, 'Unauthorized.');
        }

        $rating->delete();
        return back()->with('success', 'Rating deleted.');
    }
}
