<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'imdb_id' => 'nullable|string|max:15',
            'tmdb_id' => 'required|integer',
            'overview' => 'required|string',
            'runtime' => 'nullable|integer|min:0',
            'budget' => 'nullable|integer|min:0',
            'box_office' => 'nullable|integer|min:0',
            'poster_url' => 'nullable|url',
            'frontpage_safe' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The movie title is required.',
            'tmdb_id.required' => 'The TMDb ID is required.',
            'overview.required' => 'The movie overview is required.',
        ];
    }
}
