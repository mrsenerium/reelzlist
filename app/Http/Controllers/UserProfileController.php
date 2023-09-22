<?php
/**
 * UserProfile Controller
 *
 * PHP Version 8.1
 *
 * @category Controller
 * @package  App\Http\Controllers
 * @author   Joe Burgess <joeburgess@tds.net>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     reelzlist.com
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\MovieList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

/**
 * UserProfile Controller
 *
 * @category Controller
 * @package  App\Http\Controllers
 * @author   Joe Burgess <joeburgess@tds.net>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     reelzlist.com
 */
class UserProfileController extends Controller
{
    /**
     * Show the user profile
     *
     * @param $userProfile prfile to show
     *
     * @return view | redirectResponse
     */
    public function show(UserProfile $userProfile) : view | redirectResponse
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        // Get the currently authenticated user's profile
        $profile = UserProfile::firstOrCreate(['user_id' => auth()->user()->id]);
        $lists = MovieList::get('user_id', auth()->user()->id);

        return view('pages.user_profile', ['profile' => $profile, 'movie_lists' => $lists]);
    }

    /**
     * Update the user profile
     *
     * @param $request     core request
     * @param $userProfile profile being updated
     *
     * @return redirect
     */
    public function update(Request $request, UserProfile $userProfile)
        : view | redirectResponse
    {
        if (!Auth::check()) {
            return redirect('/');
        }
        // Get the currently authenticated user's profile
        $profile = auth()->user()->profile;

        if ($request->isMethod('get')) {
            return view('pages.update_profile', compact('profile'));
        }

        //Find a new way to validate
        /*$validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            // Add other validation rules for other fields as needed
        ]);*/

        //$profile->update($validatedData);
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

        return view('pages.user_profile', compact('profile'))->with(
            'success',
            'Profile updated successfully!'
        );
    }
}
