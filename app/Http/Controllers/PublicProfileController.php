<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::query()->where('private', false)->get();
        return view('pages.public-profiles.index', ['profiles' => $profiles, 'title' => 'Public Profiles']);
    }
}
