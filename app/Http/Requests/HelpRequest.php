<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HelpRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['nullable', 'exists:users,id'],
            'want_response' => ['required', 'boolean'],
            'status' => ['required', 'string'],
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'type' => ['required', 'string', 'in:bug-report,feature-request,general,other'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'You must provide a title for the help request.',
            'title.string' => 'The title must be a word or words.',
            'message.required' => 'You must provide a message for the help request.',
            'message.string' => 'You must use words in the message.',
            'type.required' => 'You must provide a type for the help request.',
            'type.string' => 'The type must be a word or words.',
            'type.in' => 'The type must be one of the following: bug-report, feature-request, general, other.',
        ];
    }

    public function passedValidation()
    {
        $this->merge([
            'want_response' => $this->input('want_response', 0),
        ]);
    }
}
