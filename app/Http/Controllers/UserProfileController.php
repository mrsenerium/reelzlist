<?php

namespace App\Http\Controllers;

use App\Models\MovieList;
use App\Models\UserProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    public function show(UserProfile $userProfile): view|redirectResponse
    {
        if (! auth()->check()) {
            return redirect('/');
        }

        // Get the currently authenticated user's profile
        $profile = UserProfile::firstOrCreate(['user_id' => auth()->user()->id]);
        $lists = MovieList::where('user_id', auth()->user()->id)->get();

        return view('pages.auth.user_profile', ['profile' => $profile, 'movie_lists' => $lists]);
    }

    public function update(Request $request, UserProfile $userProfile): view|redirectResponse
    {
        if (! auth()->check()) {
            return redirect('/');
        }
        // Get the currently authenticated user's profile
        $profile = auth()->user()->profile;

        if ($request->isMethod('get')) {
            return view('pages.update_profile', compact('profile'));
        }

        $request->validate(
            [
                'family_name' => ['string', 'max:255'],
                'given_name' => [
                    'string',
                    'max:255',
                ],
            ]
        );

        $profile->given_name = (isset($request->given_name) ?
            preg_replace('/\s+/', '', $request->given_name)
            : $profile->user->name);
        $profile->family_name = (isset($request->family_name) ?
            preg_replace('/\s+/', '', $request->family_name)
            : $profile->family_name);

        $profile->save();

        return view('pages.user_profile', ['success' => 'Profile updated successfully!']);
    }
}
