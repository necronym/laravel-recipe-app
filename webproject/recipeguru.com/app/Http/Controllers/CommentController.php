<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'Content' => 'required|string',
            'RecipeID' => 'required|integer|exists:Recipes,RecipeID',
        ]);

        Comment::create([
            'Content' => $request->input('Content'),
            'UserID' => Auth::id(),
            'RecipeID' => $request->input('RecipeID'),
        ]);

        return redirect()->back()->with('success', 'Comment added.');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if (Auth::id() !== $comment->UserID && Auth::user()->RoleID !== 1) {
            // Only owner or admin (RoleID = 1)
            abort(403, 'Unauthorized');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted.');
    }

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        if (Auth::id() !== $comment->UserID) {
            abort(403);
        }

        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if (Auth::id() !== $comment->UserID) {
            abort(403);
        }

        $request->validate([
            'Content' => 'required|string'
        ]);

        $comment->Content = $request->input('Content');
        $comment->save();

        return redirect()->route('recipes.show', $comment->RecipeID)->with('success', 'Comment updated.');
    }
}
