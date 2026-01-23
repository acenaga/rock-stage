<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_youtube' => Str::random(11),
            'title' => 'Sample Video',
            'description' => 'Sample description',
            'thumbnail_url' => 'https://example.com/thumbnail.jpg',
            'duration' => 120,
            'band_name' => 'Sample Band',
            'region' => 'US',
            'status' => 'pending',
        ];
    }
}
