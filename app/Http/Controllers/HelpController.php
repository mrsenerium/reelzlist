<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Help;

class HelpController extends Controller
{
    public function index()
    {
        // Authorize the user
        // get the help requests that are not resolved
        // return the view with the help requests
        $this->authorize('index', Help::class);
        return view('pages.help.index',
            [
                'unresolved' => Help::where('resolved', false)->get(),
                'resolved' => Help::where('resolved', true)->get()
            ])
        ;
    }

    public function create()
    {
        return view('pages.help.create');
    }

    public function store(Request $request)
    {
        //
        return redirect()->route('home')->with('success', 'Help request submitted.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }
}
