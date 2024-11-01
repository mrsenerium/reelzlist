<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'rating' => ['numeric', 'min:1'],
            'body' => ['required', 'string'],
            'user_id' => ['required', 'exists:users,id'],
            'movie_id' => ['required', 'exists:movies,id'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'You must provide a name for the review.',
            'name.string' => 'The name must be a word or words.',
            'body.required' => 'You must provide a review.',
            'body.string' => 'You must use words in the review.',
            'rating.required' => 'A minimum of 1 star is required.',
        ];
    }

    public function passedValidation()
    {
        $this->merge([
            'private' => $this->input('private', 0),
        ]);
    }
}
