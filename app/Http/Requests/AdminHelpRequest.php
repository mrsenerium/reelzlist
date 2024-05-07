<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminHelpRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'type' => ['required', 'string', 'max:255'],
            'want_response' => ['nullable', 'boolean'],
            'read' => ['required', 'boolean'],
            'response' => ['nullable', 'string'],
            'status' => ['required', 'string', 'max:255'],
            'resolved' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'message.required' => 'Message is required',
            'type.required' => 'Type is required',
            'want_response.required' => 'Want response is required',
            'read.required' => 'Read is required',
            'status.required' => 'Status is required',
        ];
    }

    public function passedValidation()
    {
        $this->merge([
            'want_response' => $this->input('want_response', 0),
            'read' => $this->input('read', 0),
            'resolved' => $this->input('status') === 'resolved',
        ]);
    }
}
