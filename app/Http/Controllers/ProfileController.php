<?php

namespace App\Http\Controllers;

use App\Models\MovieList;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show($id): view|redirectResponse
    {
        $user = User::query()->where('id', auth()->user()->id)->first();
        $profile = Profile::query()->where('user_id', $user->id)->firstOrCreate();
        $this->authorize('view', $profile);

        return view('pages.profile.show', [
            'user' => $user,
            'profile' => $profile,
            'movie_lists' => MovieList::where('user_id', $user->id)->get()
        ]);
    }

    public function edit(Request $request, $id): view|redirectResponse
    {
        $profile = Profile::query()->where('id', $id)->first();
        $this->authorize('edit', $profile);

        return view('pages.profile.edit', ['profile' => $profile]);
    }

    public function update(Request $request)
    {
        $profile = Profile::query()->where('user_id', $request->user_id)->with('user')->first();
        $this->authorize('edit', $profile);

        $profile->update([
            'given_name' => (isset($request->given_name) ?
                preg_replace('/\s+/', '', $request->given_name)
                : $profile->user->name),
            'family_name' => (isset($request->family_name) ?
                preg_replace('/\s+/', '', $request->family_name)
                : $profile->family_name),
            'birthdate' => $request->birthdate
        ]);

        return view('pages.profile.show', [
            'profile' => $profile,
            'user' => $profile->user,
            'movie_lists' => MovieList::where('user_id', $profile->user_id)->get(),
            'success' => 'Profile updated successfully!'
        ]);
    }
}
