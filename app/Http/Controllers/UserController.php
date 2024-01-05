<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MovieList;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('view', User::query()->where('id', auth()->user()->id)->first());
        return view('pages.users.index', [
            'users' => User::query()->get()
        ]);
    }

    public function edit($id)
    {
        $this->authorize('edit', User::query()->where('id', auth()->user()->id)->first());
        return view('pages.users.edit', [
            'user' => User::query()->where('id', $id)->first()
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('edit', User::query()->where('id', auth()->user()->id)->first());
        $user = User::query()->where('id', $request->user_id)->first();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role, 
        ]);

        return view('pages.users.index', [
            'users' => User::query()->get()
        ]);
    }

    public function show($id)
    {
        $this->authorize('view', User::query()->where('id', auth()->user()->id)->first());
        return view('pages.users.show', [
            'user' => User::query()->where('id', $id)->first(),
            'movieLists' => MovieList::query()->where('user_id', $id)->get(),
            'reviews' => Review::query()->where('user_id', $id)->get(),
        ]);
    }

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
