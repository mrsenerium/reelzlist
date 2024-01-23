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
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'You must give the review a name',
            'name.string' => 'The name must be a word or words',
            'body.required' => 'You must give a review',
            'body.string' => 'You must use words',
            'rating.required' => 'A minimum of 1 star is required'
        ];
    }

    public function passedValidation()
    {
        $this->merge([
            'private' => ($this->private ?? 0)
        ]);
    }
}
