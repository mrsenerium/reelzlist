<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\HelpRequest;
use App\Models\Help;

class HelpController extends Controller
{
    public function index()
    {
        if(!$this->authorize('index', Help::class)) {
            return redirect()->route('pages.help.create');
        }

        return view('pages.help.index', [
                'unresolved' => Help::where('resolved', false)->get(),
                'resolved' => Help::where('resolved', true)->get()
        ]);
    }

    public function create()
    {
        return view('pages.help.create');
    }

    public function store(HelpRequest $request)
    {
        Help::create($request->validated());

        return redirect()->route('home')->with('success', 'Help request submitted.');
    }

    public function show(string $id)
    {
        //
        dd($id);
    }

    public function edit(string $id)
    {
        //
        dd($id);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        $this->authorize('delete', Help::class);
        Help::where('id', $id)->delete();
        return redirect()->route('help.index');
    }
}
