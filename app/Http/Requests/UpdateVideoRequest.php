<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVideoRequest extends FormRequest
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
        $video = $this->route('video');

        return [
            'id_youtube' => ['sometimes', 'string', 'max:255', "unique:videos,id_youtube,{$video->id}"],
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'thumbnail_url' => ['nullable', 'url', 'max:500'],
            'duration' => ['sometimes', 'integer', 'min:0'],
            'band_name' => ['sometimes', 'string', 'max:255'],
            'region' => ['sometimes', 'string', 'max:255'],
            'status' => ['sometimes', 'string', 'in:pending,processing,completed,failed,approved,rejected'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_youtube.unique' => 'This YouTube ID already exists.',
            'duration.integer' => 'The duration must be an integer.',
            'duration.min' => 'The duration must be at least 0 seconds.',
            'status.in' => 'The status must be one of: pending, processing, completed, failed, approved, rejected.',
            'thumbnail_url.url' => 'The thumbnail URL must be a valid URL.',
        ];
    }
}
