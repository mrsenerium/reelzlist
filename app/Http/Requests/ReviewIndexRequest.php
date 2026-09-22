<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'movie' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'movie.string' => 'The movie name must be a word or words.',
            'title.string' => 'The review title must be a word or words.',
            'rating.integer' => 'The star rating must be a number from 1 to 5.',
            'rating.min' => 'The star rating must be between 1 and 5.',
            'rating.max' => 'The star rating must be between 1 and 5.',
        ];
    }

    public function movie(): ?string
    {
        return $this->query('movie');
    }

    public function title(): ?string
    {
        return $this->query('title');
    }

    public function rating(): ?int
    {
        $rating = $this->query('rating');

        return $rating === null ? null : (int) $rating;
    }
}
