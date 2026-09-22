<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ReviewIndexTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(): User
    {
        return User::factory()->create([
            'password' => Hash::make('password'),
        ]);
    }

    public function test_guest_is_redirected_from_reviews_index(): void
    {
        $this->get(route('review.index'))->assertRedirect('/');
    }

    public function test_user_sees_only_their_reviews(): void
    {
        $user = $this->makeUser();
        $other = $this->makeUser();
        $movie = Movie::factory()->create(['title' => 'Inception']);

        Review::factory()->create([
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'name' => 'My favorite dream',
            'rating' => 5,
        ]);
        Review::factory()->create([
            'user_id' => $other->id,
            'movie_id' => $movie->id,
            'name' => 'Someone else wrote this',
            'rating' => 2,
        ]);

        $this->actingAs($user)
            ->get(route('review.index'))
            ->assertOk()
            ->assertSee('My favorite dream')
            ->assertSee('Inception')
            ->assertDontSee('Someone else wrote this');
    }

    public function test_reviews_can_be_filtered_by_movie_name(): void
    {
        $user = $this->makeUser();
        $inception = Movie::factory()->create(['title' => 'Inception']);
        $up = Movie::factory()->create(['title' => 'Up']);

        Review::factory()->create([
            'user_id' => $user->id,
            'movie_id' => $inception->id,
            'name' => 'Dream review',
        ]);
        Review::factory()->create([
            'user_id' => $user->id,
            'movie_id' => $up->id,
            'name' => 'Balloon review',
        ]);

        $this->actingAs($user)
            ->get(route('review.index', ['movie' => 'incep']))
            ->assertOk()
            ->assertSee('Dream review')
            ->assertDontSee('Balloon review');
    }

    public function test_reviews_can_be_filtered_by_review_title(): void
    {
        $user = $this->makeUser();

        Review::factory()->create([
            'user_id' => $user->id,
            'name' => 'A masterpiece',
        ]);
        Review::factory()->create([
            'user_id' => $user->id,
            'name' => 'Pretty okay',
        ]);

        $this->actingAs($user)
            ->get(route('review.index', ['title' => 'master']))
            ->assertOk()
            ->assertSee('A masterpiece')
            ->assertDontSee('Pretty okay');
    }

    public function test_reviews_can_be_filtered_by_star_rating(): void
    {
        $user = $this->makeUser();

        Review::factory()->create([
            'user_id' => $user->id,
            'name' => 'Five star take',
            'rating' => 5,
        ]);
        Review::factory()->create([
            'user_id' => $user->id,
            'name' => 'Three star take',
            'rating' => 3,
        ]);

        $this->actingAs($user)
            ->get(route('review.index', ['rating' => 5]))
            ->assertOk()
            ->assertSee('Five star take')
            ->assertDontSee('Three star take');
    }
}
