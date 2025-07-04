<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function ban(User $user)
    {
        // Optional: Ensure only admins can perform this
        if (auth()->user()->RoleID !== 1) {
            abort(403, 'Unauthorized');
        }

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
