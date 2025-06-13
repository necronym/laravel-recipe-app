<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function ban(User $user)
    {

        if (auth()->user()->RoleID !== 1) {
            abort(403, 'Unauthorized');
        }

        // Delete all related data before user
        $user->comments()->delete();
        $user->ratings()->delete();
        $recipeIds = $user->recipes->pluck('RecipeID');
        \DB::table('recipecategories')->whereIn('RecipeID', $recipeIds)->delete();
        \DB::table('recipeingredients')->whereIn('RecipeID', $recipeIds)->delete();
        \DB::table('ratings')->whereIn('RecipeID', $recipeIds)->delete();
        \DB::table('comments')->whereIn('RecipeID', $recipeIds)->delete();
        $user->recipes()->delete();
        $user->delete();

        return redirect()->route('home')->with('success', 'User has been banned.');
    }
    
    public function reports()
    {
        return view('admin.reports', [
            'recipeReports' => Report::whereNotNull('RecipeID')->with('recipe')->get(),
            'commentReports' => Report::whereNotNull('CommentID')->with('comment.recipe')->get(),
            'userReports' => Report::whereNotNull('UserID')->with('user')->get(),
        ]);
    }
}
