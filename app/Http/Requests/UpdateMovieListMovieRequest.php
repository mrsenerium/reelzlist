<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieListMovieRequest extends FormRequest
{
    public function authorize(): bool
    {
        $movieList = $this->route('movie_list');

        return $this->user() !== null && $this->user()->can('edit', $movieList);
    }

    public function rules(): array
    {
        return [
            'is_watched' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'is_watched.required' => 'You must specify whether the movie is watched.',
            'is_watched.boolean' => 'Watched must be true or false.',
        ];
    }
}
