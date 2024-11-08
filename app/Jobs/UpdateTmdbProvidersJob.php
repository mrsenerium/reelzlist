<?php

namespace App\Jobs;

use App\Http\Resources\TMDbConnection;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateTmdbProvidersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $providers = (new TMDBconnection)->getProviders();

        \Log::info('updating providers from TMDb');

        if (! isset($providers->results)) {
            \Log::error('unable to get providers from TMDb');

            return;
        }
        foreach ($providers->results as $provider) {
            if (is_null($provider->logo_path)) {
                continue;
            }
            Subscription::updateOrCreate(
                ['tmdb_provider_id' => $provider->provider_id],
                [
                    'name' => $provider->provider_name,
                    'url' => 'https://image.tmdb.org/t/p/original'.$provider->logo_path,
                ]
            );
        }

        \Log::info('providers updated from TMDb');
    }
}
