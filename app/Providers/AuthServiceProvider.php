<?php

namespace App\Providers;

use App\Models\Help;
use App\Models\MovieList;
use App\Models\Review;
use App\Models\Subscription;
use App\Models\User;
use App\Policies\HelpPolicy;
use App\Policies\MovieListPolicy;
use App\Policies\ReviewPolicy;
use App\Policies\SubscriptionPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Review::class => ReviewPolicy::class,
        MovieList::class => MovieListPolicy::class,
        User::class => UserPolicy::class,
        Help::class => HelpPolicy::class,
        Subscription::class => SubscriptionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
