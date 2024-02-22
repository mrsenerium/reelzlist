<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'given_name' => 'required|string|max:255',
            'family_name' => 'required|string|max:255',
            'birthdate' => 'nullable|date',
        ];
    }
}
