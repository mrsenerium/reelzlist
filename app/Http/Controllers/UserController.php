<?php
/**
 * User Controller
 *
 * PHP Version 8.1
 *
 * @category Controller
 *
 * @author   Joe Burgess <joeburgess@tds.net>
 * @license  https://opensource.org/licenses/MIT MIT License
 *
 * @link     reelzlist.com
 */

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * User Controller
 *
 * @category Controller
 *
 * @author   Joe Burgess <joeburgess@tds.net>
 * @license  https://opensource.org/licenses/MIT MIT License
 *
 * @link     reelzlist.com
 */
class UserController extends Controller
{
    /**
     * User Login
     *
     * @param  Request  $request core request
     */
    public function login(Request $request): view
    {
        if ($request->isMethod('post')) {
            $credentials = $request->validate(
                [
                    'email' => ['required', 'email'],
                    'password' => ['required'],
                ]
            );

            if (auth()->attempt($credentials)) {
                $request->session()->regenerate();

                return view('home');
            } else {
                return view('pages.login')->withErrors(
                    [
                        'email' => 'The provided credentials do not match our records.',
                    ]
                );
            }
        }

        return view('pages.login');
    }

    /**
     * Logs User out
     *
     * @param  Request  $request core request
     * @return view
     */
    public function logout(Request $request): RedirectResponse
    {
        //Handle logout
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Register a new User
     *
     * @param  Request  $request core request
     */
    public function register(Request $request): view
    {
        //register
        return view('pages.register');
    }

    /**
     * Validate and Store Registration
     *
     * @param  Request  $request core request
     * @return view
     */
    public function storeRegistration(Request $request): RedirectResponse
    {
        //Validate and Store the Registration
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'unique:users',
                ],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]
        );

        $user = User::create(request(['name', 'email', 'password']));
        $userProfile = UserProfile::create(['user_id' => $user->id]);

        return redirect()->back()->with('success', 'Registration completed');
    }
}
