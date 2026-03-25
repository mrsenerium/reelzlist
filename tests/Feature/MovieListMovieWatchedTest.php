<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\MovieList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MovieListMovieWatchedTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(): User
    {
        return User::factory()->create([
            'password' => Hash::make('password'),
        ]);
    }

    public function test_owner_can_mark_movie_watched_on_list(): void
    {
        $user = $this->makeUser();
        $movieList = MovieList::create([
            'user_id' => $user->id,
            'name' => 'My List',
            'private' => 0,
        ]);
        $movie = Movie::factory()->create();
        $movieList->movie()->attach($movie->id);

        $response = $this->actingAs($user)->patch(
            route('movie-lists.movies.update', ['movie_list' => $movieList->id, 'movie' => $movie->slug]),
            ['is_watched' => true]
        );

        $response->assertRedirect();
        $this->assertTrue(
            (bool) $movieList->fresh()->movie()->where('movies.id', $movie->id)->first()->pivot->is_watched
        );
    }

    public function test_guest_cannot_update_watched(): void
    {
        $user = $this->makeUser();
        $movieList = MovieList::create([
            'user_id' => $user->id,
            'name' => 'My List',
            'private' => 0,
        ]);
        $movie = Movie::factory()->create();
        $movieList->movie()->attach($movie->id);

        $response = $this->patch(
            route('movie-lists.movies.update', ['movie_list' => $movieList->id, 'movie' => $movie->slug]),
            ['is_watched' => true]
        );

        $response->assertForbidden();
    }

    public function test_other_user_cannot_update_watched(): void
    {
        $owner = $this->makeUser();
        $other = $this->makeUser();
        $movieList = MovieList::create([
            'user_id' => $owner->id,
            'name' => 'My List',
            'private' => 0,
        ]);
        $movie = Movie::factory()->create();
        $movieList->movie()->attach($movie->id);

        $response = $this->actingAs($other)->patch(
            route('movie-lists.movies.update', ['movie_list' => $movieList->id, 'movie' => $movie->slug]),
            ['is_watched' => true]
        );

        $response->assertForbidden();
    }

    public function test_update_returns_404_when_movie_not_on_list(): void
    {
        $user = $this->makeUser();
        $movieList = MovieList::create([
            'user_id' => $user->id,
            'name' => 'My List',
            'private' => 0,
        ]);
        $movie = Movie::factory()->create();

        $response = $this->actingAs($user)->patch(
            route('movie-lists.movies.update', ['movie_list' => $movieList->id, 'movie' => $movie->slug]),
            ['is_watched' => true]
        );

        $response->assertNotFound();
    }
}
