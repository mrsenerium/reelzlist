<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function index()
    {
        $q = request()->input('q');

        $this->authorize('viewAny', Subscription::class);

        return view('pages.subscriptions.index', [
            'subscriptions' => Subscription::query()
                ->when($q, function ($subscriptions, $q) {
                    $subscriptions->where('name', 'like', "%{$q}%");
                })
                ->paginate(25)
                ->appends(['q' => $q]),
            'userSubscriptions' => auth()->user()->subscriptions,
        ]);
    }

    public function store(Request $request)
    {
        $subscription = Subscription::find($request->subscription_id);
        $user = auth()->user();
        $user->subscriptions()->attach($subscription);

        $q = request()->input('q');
        //dd($request->all());

        return redirect()->route('subscriptions.index', ['q' => $q]);
    }

    public function destroy(string $id)
    {
        $subscription = Subscription::find($id);
        $user = auth()->user();
        $user->subscriptions()->detach($subscription);

        return redirect()->route('subscriptions.index');
    }
}
