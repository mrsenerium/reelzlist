<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'You must provide a name for the registration.',
            'name.string' => 'The name must be a word or words.',
            'email.required' => 'You must provide an email for the registration.',
            'email.string' => 'The email must be a word or words.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email must be unique.',
            'password.required' => 'You must provide a password for the registration.',
            'password.string' => 'The password must be a word or words.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password don\'t match.',
        ];
    }
}
