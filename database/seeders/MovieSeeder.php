<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Movie;
use App\Http\Resources\TMDbConnection;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tmdbArray = [
            23478,
            536554,
            7443,
            284674,
            653601,
            10692,
            18462,
            12149,
            773,
            19794,
            820609,
            458305,
            9966,
            880841,
            510388,
        ];

        $tmdb = new TMDbConnection();
        foreach ($tmdbArray as $id) {
            $tmdbData = $tmdb->singleMovieData($id);
            $movie = Movie::firstOrCreate([
                'title' => $tmdbData->title ?? null,
                'overview' => $tmdbData->overview ?? null,
                'imdb_id' => $tmdbData->imdb_id ?? null,
                'runtime' => $tmdbData->runtime ?? null,
                'box_office' => $tmdbData->revenue ?? null,
                'budget' => $tmdbData->budget ?? null,
                'release_date' => $tmdbData->release_date,
                'tmdb_id' => $tmdbData->id,
            ]);
            $movie->updateOMDBData();
        }
    }
}
