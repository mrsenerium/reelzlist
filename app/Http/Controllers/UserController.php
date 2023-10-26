<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
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
                return view('pages.auth.login')->withErrors(
                    [
                        'email' => 'The provided credentials do not match our records.',
                    ]
                );
            }
        }

        return view('pages.auth.login');
    }

    public function logout(Request $request): RedirectResponse
    {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function register(Request $request): view
    {
        //register
        return view('pages.auth.register');
    }

    public function storeRegistration(Request $request): RedirectResponse
    {
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

        return redirect()->back()->with('success', 'Registration completed');
    }
}
