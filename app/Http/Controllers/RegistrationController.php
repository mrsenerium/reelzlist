<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegistrationRequest;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('pages.registration.create');
    }

    public function store(RegistrationRequest $request)
    {
        $user = User::create(
            $request->only('name', 'email')
            + ['password' => bcrypt($request->input('password'))]
        );

        return redirect('/login')->with('success', 'Registration completed');
    }
}
