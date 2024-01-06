<?php

namespace App\Http\Controllers;

use App\Models\MovieList;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show($id): view|redirectResponse
    {
        if (! auth()->check()) {
            return redirect('/');
        }

        $profile = Profile::firstOrCreate(['user_id' => auth()->user()->id]);
        $lists = MovieList::where('user_id', auth()->user()->id)->get();

        return view('pages.profile.show', ['profile' => $profile, 'movie_lists' => $lists]);
    }

    public function edit(Request $request, $id): view|redirectResponse
    {
        if (! auth()->check()) {
            return redirect('/');
        }
        $profile = auth()->user()->profile;

        return view('pages.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = Profile::query()->where('user_id', $request->user_id)->first();

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
            'movie_lists' => MovieList::where('user_id', $profile->user_id)->get(),
            'success' => 'Profile updated successfully!'
        ]);
    }
}
