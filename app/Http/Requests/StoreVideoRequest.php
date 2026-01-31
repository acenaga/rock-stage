<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
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
            'id_youtube' => ['required', 'string', 'max:255', 'unique:videos,id_youtube'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'thumbnail_url' => ['nullable', 'url', 'max:500'],
            'duration' => ['required', 'integer', 'min:0'],
            'band_name' => ['required', 'string', 'max:255'],
            'region' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:pending,processing,completed,failed,approved,rejected'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_youtube.required' => 'The YouTube ID field is required.',
            'id_youtube.unique' => 'This YouTube ID already exists.',
            'title.required' => 'The title field is required.',
            'duration.required' => 'The duration field is required.',
            'duration.integer' => 'The duration must be an integer.',
            'duration.min' => 'The duration must be at least 0 seconds.',
            'band_name.required' => 'The band name field is required.',
            'region.required' => 'The region field is required.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be one of: pending, processing, completed, failed, approved, rejected.',
            'thumbnail_url.url' => 'The thumbnail URL must be a valid URL.',
        ];
    }
}
