<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\MovieList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class WhatToWatchTest extends TestCase
{
    use RefreshDatabase;

    private int $tmdbId = 1000;

    private function makeUser(): User
    {
        return User::factory()->create([
            'password' => Hash::make('password'),
        ]);
    }

    private function makeList(User $user, string $name): MovieList
    {
        return MovieList::create([
            'user_id' => $user->id,
            'name' => $name,
            'private' => 0,
        ]);
    }

    private function makeGenre(string $name): Genre
    {
        return Genre::create([
            'tmdb_id' => $this->tmdbId++,
            'name' => $name,
        ]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('what-to-watch'));

        $response->assertRedirect(route('login'));
    }

    public function test_suggestions_come_only_from_the_signed_in_users_lists(): void
    {
        $owner = $this->makeUser();
        $other = $this->makeUser();
        $ownMovie = Movie::factory()->create(['title' => 'Owner Pick']);
        $otherMovie = Movie::factory()->create(['title' => 'Stranger Pick']);
        $this->makeList($owner, 'Mine')->movie()->attach($ownMovie->id);
        $this->makeList($other, 'Theirs')->movie()->attach($otherMovie->id);

        $response = $this->actingAs($owner)->get(route('what-to-watch'));

        $response->assertOk();
        $response->assertSee('Owner Pick');
        $response->assertDontSee('Stranger Pick');
        $response->assertViewHas('movies', function ($movies) use ($ownMovie) {
            return $movies->count() === 1 && $movies->first()->is($ownMovie);
        });
    }

    public function test_a_movie_on_two_lists_is_suggested_once(): void
    {
        $user = $this->makeUser();
        $movie = Movie::factory()->create(['title' => 'Shared Pick']);
        $weekend = $this->makeList($user, 'Weekend');
        $favorites = $this->makeList($user, 'Favorites');
        $weekend->movie()->attach($movie->id);
        $favorites->movie()->attach($movie->id);

        $response = $this->actingAs($user)->get(route('what-to-watch'));

        $response->assertOk();
        $response->assertViewHas('movies', function ($movies) use ($movie) {
            return $movies->count() === 1
                && $movies->first()->is($movie)
                && $movies->first()->movieList->count() === 2;
        });
        $response->assertSee('Weekend');
        $response->assertSee('Favorites');
        $this->assertSame(1, substr_count($response->getContent(), 'Shared Pick'));
    }

    public function test_genre_filter_drops_movies_without_that_genre(): void
    {
        $user = $this->makeUser();
        $list = $this->makeList($user, 'Mine');
        $comedy = Movie::factory()->create(['title' => 'Comedy Night']);
        $drama = Movie::factory()->create(['title' => 'Drama Night']);
        $comedy->addGenre($this->makeGenre('Comedy'));
        $drama->addGenre($this->makeGenre('Drama'));
        $list->movie()->attach([$comedy->id, $drama->id]);

        $response = $this->actingAs($user)->get(route('what-to-watch', ['genre' => 'Comedy']));

        $response->assertOk();
        $response->assertSee('Comedy Night');
        $response->assertDontSee('Drama Night');
        $response->assertViewHas('genreList', function ($genres) {
            return $genres->pluck('name')->sort()->values()->all() === ['Comedy', 'Drama'];
        });
    }

    public function test_hide_watched_keeps_a_movie_that_is_still_unwatched_on_one_list(): void
    {
        $user = $this->makeUser();
        $first = $this->makeList($user, 'First');
        $second = $this->makeList($user, 'Second');
        $fullyWatched = Movie::factory()->create(['title' => 'Already Seen']);
        $stillOpen = Movie::factory()->create(['title' => 'Still Open']);
        $first->movie()->attach($fullyWatched->id, ['is_watched' => true]);
        $second->movie()->attach($fullyWatched->id, ['is_watched' => true]);
        $first->movie()->attach($stillOpen->id, ['is_watched' => true]);
        $second->movie()->attach($stillOpen->id, ['is_watched' => false]);

        $hidden = $this->actingAs($user)->get(route('what-to-watch'));

        $hidden->assertOk();
        $hidden->assertDontSee('Already Seen');
        $hidden->assertSee('Still Open');

        $shown = $this->actingAs($user)->get(route('what-to-watch', ['hideWatched' => 0]));

        $shown->assertOk();
        $shown->assertSee('Already Seen');
        $shown->assertSee('Still Open');
    }

    public function test_fewer_than_three_matches_returns_only_those_matches(): void
    {
        $user = $this->makeUser();
        $list = $this->makeList($user, 'Mine');
        $only = Movie::factory()->create(['title' => 'Only One']);
        $list->movie()->attach($only->id);

        $response = $this->actingAs($user)->get(route('what-to-watch'));

        $response->assertOk();
        $response->assertViewHas('movies', function ($movies) use ($only) {
            return $movies->count() === 1 && $movies->first()->is($only);
        });
    }

    public function test_at_most_three_movies_are_suggested(): void
    {
        $user = $this->makeUser();
        $list = $this->makeList($user, 'Mine');
        $movies = Movie::factory()->count(4)->create();
        $list->movie()->attach($movies->pluck('id'));

        $response = $this->actingAs($user)->get(route('what-to-watch'));

        $response->assertOk();
        $response->assertViewHas('movies', function ($movies) {
            return $movies->count() === 3;
        });
    }

    public function test_empty_state_links_to_create_a_list_when_the_user_has_none(): void
    {
        $user = $this->makeUser();

        $response = $this->actingAs($user)->get(route('what-to-watch'));

        $response->assertOk();
        $response->assertSee('Nothing matches those filters.');
        $response->assertSee('Create a movie list');
        $response->assertViewHas('hasLists', false);
    }

    public function test_year_filter_limits_suggestions_to_that_release_year(): void
    {
        $user = $this->makeUser();
        $list = $this->makeList($user, 'Mine');
        $older = Movie::factory()->create([
            'title' => 'Ninety Nine',
            'release_date' => '1999-06-01',
        ]);
        $newer = Movie::factory()->create([
            'title' => 'Two Thousand',
            'release_date' => '2001-01-01',
        ]);
        $list->movie()->attach([$older->id, $newer->id]);

        $response = $this->actingAs($user)->get(route('what-to-watch', ['year' => 1999]));

        $response->assertOk();
        $response->assertSee('Ninety Nine');
        $response->assertDontSee('Two Thousand');
    }
}
