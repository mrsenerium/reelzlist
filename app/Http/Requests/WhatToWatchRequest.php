<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WhatToWatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'genre' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'integer', 'min:1910', 'max:2100'],
            'hideWatched' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'genre.max' => 'Genre must be 255 characters or fewer.',
            'year.integer' => 'Year must be a number.',
            'year.min' => 'Year must be 1910 or later.',
            'year.max' => 'Year must be 2100 or earlier.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'genre' => $this->query('genre'),
            'year' => $this->query('year'),
            'hideWatched' => $this->boolean('hideWatched', true),
        ]);
    }

    public function hideWatched(): bool
    {
        return $this->boolean('hideWatched', true);
    }

    public function genre(): ?string
    {
        return $this->input('genre');
    }

    public function year(): ?int
    {
        $year = $this->input('year');

        return $year === null ? null : (int) $year;
    }
}
