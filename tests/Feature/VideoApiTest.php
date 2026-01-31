<?php

use App\Models\Video;

it('can list videos', function () {
    Video::factory()->count(3)->create();

    $response = $this->getJson('/api/v1/videos');

    $response->assertSuccessful()
        ->assertJsonCount(3, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'id_youtube',
                    'title',
                    'description',
                    'thumbnail_url',
                    'duration',
                    'duration_formatted',
                    'band_name',
                    'region',
                    'status',
                    'created_at',
                    'updated_at',
                ],
            ],
            'links',
            'meta',
        ]);
});

it('can create a video', function () {
    $videoData = [
        'id_youtube' => 'dQw4w9WgXcQ',
        'title' => 'Never Gonna Give You Up',
        'description' => 'Classic music video',
        'thumbnail_url' => 'https://img.youtube.com/vi/dQw4w9WgXcQ/hqdefault.jpg',
        'duration' => 212,
        'band_name' => 'Rick Astley',
        'region' => 'UK',
        'status' => 'pending',
    ];

    $response = $this->postJson('/api/v1/videos', $videoData);

    $response->assertCreated()
        ->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'id_youtube',
                'title',
                'description',
                'thumbnail_url',
                'duration',
                'duration_formatted',
                'band_name',
                'region',
                'status',
                'created_at',
                'updated_at',
            ],
        ])
        ->assertJson([
            'message' => 'Video created successfully',
            'data' => [
                'id_youtube' => 'dQw4w9WgXcQ',
                'title' => 'Never Gonna Give You Up',
                'duration' => 212,
                'band_name' => 'Rick Astley',
                'region' => 'UK',
                'status' => 'pending',
            ],
        ]);

    $this->assertDatabaseHas('videos', [
        'id_youtube' => 'dQw4w9WgXcQ',
        'title' => 'Never Gonna Give You Up',
    ]);
});

it('validates video creation', function (array $data, array $errors) {
    $response = $this->postJson('/api/v1/videos', $data);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors($errors);
})->with([
    'missing required fields' => [
        [],
        ['id_youtube', 'title', 'duration', 'band_name', 'region', 'status'],
    ],
    'invalid youtube id' => [
        ['id_youtube' => ''],
        ['id_youtube'],
    ],
    'invalid duration' => [
        [
            'id_youtube' => 'dQw4w9WgXcQ',
            'title' => 'Test Video',
            'duration' => -1,
            'band_name' => 'Test Band',
            'region' => 'US',
            'status' => 'pending',
        ],
        ['duration'],
    ],
    'invalid status' => [
        [
            'id_youtube' => 'dQw4w9WgXcQ',
            'title' => 'Test Video',
            'duration' => 120,
            'band_name' => 'Test Band',
            'region' => 'US',
            'status' => 'invalid',
        ],
        ['status'],
    ],
]);

it('can show a video', function () {
    $video = Video::factory()->create();

    $response = $this->getJson("/api/v1/videos/{$video->id}");

    $response->assertSuccessful()
        ->assertJsonStructure([
            'data' => [
                'id',
                'id_youtube',
                'title',
                'description',
                'thumbnail_url',
                'duration',
                'duration_formatted',
                'band_name',
                'region',
                'status',
                'created_at',
                'updated_at',
            ],
        ])
        ->assertJson([
            'data' => [
                'id' => $video->id,
                'id_youtube' => $video->id_youtube,
                'title' => $video->title,
            ],
        ]);
});

it('can update a video', function () {
    $video = Video::factory()->create();

    $updateData = [
        'title' => 'Updated Title',
        'status' => 'approved',
    ];

    $response = $this->putJson("/api/v1/videos/{$video->id}", $updateData);

    $response->assertSuccessful()
        ->assertJson([
            'message' => 'Video updated successfully',
            'data' => [
                'id' => $video->id,
                'title' => 'Updated Title',
                'status' => 'approved',
            ],
        ]);

    $this->assertDatabaseHas('videos', [
        'id' => $video->id,
        'title' => 'Updated Title',
        'status' => 'approved',
    ]);
});

it('can delete a video', function () {
    $video = Video::factory()->create();

    $response = $this->deleteJson("/api/v1/videos/{$video->id}");

    $response->assertNoContent();

    $this->assertDatabaseMissing('videos', [
        'id' => $video->id,
    ]);
});
