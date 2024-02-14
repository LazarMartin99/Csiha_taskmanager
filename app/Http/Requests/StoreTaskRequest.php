<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'estimated_time' => 'nullable|date_format:H:i',
            'used_time' => 'nullable|date_format:H:i',
            'status' => 'required|string|in:Inprogress,Completed',
        ];
    }
}
