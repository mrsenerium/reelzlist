<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class MovieListShowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'itemsPerPage' => ['nullable', 'integer', 'in:10,25,50,100'],
            'page' => ['nullable', 'integer', 'min:1'],
            'hideWatched' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'search' => $this->query('search'),
            'itemsPerPage' => $this->query('itemsPerPage', 25),
            'page' => $this->query('page', 1),
            'hideWatched' => $this->boolean('hideWatched', true),
        ]);
    }

    public function hideWatched(): bool
    {
        return $this->boolean('hideWatched', true);
    }

    public function itemsPerPage(): int
    {
        return (int) $this->input('itemsPerPage', 25);
    }

    public function search(): ?string
    {
        return $this->input('search');
    }
}
