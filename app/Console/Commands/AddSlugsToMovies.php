<?php

namespace App\Console\Commands;

use App\Models\Movie;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AddSlugsToMovies extends Command
{
    protected $signature = 'add-slugs-to-movies';

    protected $description = 'Command description';

    public function handle()
    {
        $movies = Movie::where('slug', null)->get();

        foreach ($movies as $movie) {
            $this->info('Adding slug to ' . $movie->title);

            $movie->slug = Str::slug($movie->id . '-'. $movie->title);
            $movie->save();
        }

        $this->info('All done!');

        return 0;
    }
}
