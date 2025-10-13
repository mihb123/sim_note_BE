<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNoteRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:notes,id',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'is_save' => 'nullable|boolean',
            'user_id' => 'required|integer|exists:users,id',
            'updated_at' => 'nullable|date',
        ];
    }
}
