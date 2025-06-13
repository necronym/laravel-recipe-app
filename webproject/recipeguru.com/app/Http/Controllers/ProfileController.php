<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['Avatar'] = $path;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'Bio' => $data['Bio'] ?? $user->Bio,
            'Avatar' => $data['Avatar'] ?? $user->Avatar,
        ]);

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display the user's dashboard.
     */
    public function dashboard()
    {
        $user = auth()->user();

        $recentComments = \App\Models\Comment::with('recipe')
            ->where('UserID', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $recentRatings = \App\Models\Rating::with('recipe')
            ->where('UserID', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Fetch full list of user's recipes
        $recipes = \App\Models\Recipe::withAvg('ratings', 'Score')
            ->where('UserID', $user->id)
            ->latest()
            ->paginate(5);

        return view('profile.dashboard', compact(
            'user',
            'recipes',
            'recentComments',
            'recentRatings'
        ));
    }

    /**
     * Display a public profile.
     */
    public function publicProfile($id)
    {
        $user = User::findOrFail($id);
        $recipes = $user->recipes()
            ->withAvg('ratings', 'Score')
            ->latest()
            ->paginate(5);
        return view('profile.public', compact('user', 'recipes'));
    }

    public function ban($id)
    {
        $user = User::findOrFail($id);

        if (auth()->user()->RoleID !== 1) {
            abort(403, 'Unauthorized.');
        }

        // Delete recipes first due to foreign key
        $user->recipes()->delete();

        // Delete user
        $user->delete();

        return redirect('/')->with('success', 'User banned and deleted.');
    }
    
}
