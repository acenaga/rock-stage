<?php

use App\Jobs\ProcessYouTubeVideo;
use App\Models\Video;
use App\Services\YouTubeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function Pest\Laravel\mock;

uses(TestCase::class, RefreshDatabase::class);

it('marks video as failed when youtube id is missing', function (): void {
    $video = Video::factory()->create();
    $video->id_youtube = '';

    $service = mock(YouTubeService::class);
    $service->shouldNotReceive('getVideoDetails');

    (new ProcessYouTubeVideo($video))->handle($service);

    $video->refresh();

    expect($video->status)->toBe('failed');
});

it('updates video details when service returns data', function (): void {
    $video = Video::factory()->create(['status' => 'pending']);

    $service = mock(YouTubeService::class);
    $service->shouldReceive('getVideoDetails')
        ->once()
        ->with($video->id_youtube)
        ->andReturn([
            'youtube_id' => $video->id_youtube,
            'title' => 'Sample Title',
            'description' => 'Sample description',
            'thumbnail_url' => 'https://example.com/thumbnail.jpg',
            'duration' => 123,
            'band_name' => 'Sample Channel',
        ]);

    (new ProcessYouTubeVideo($video))->handle($service);

    $video->refresh();

    expect($video->status)->toBe('completed')
        ->and($video->title)->toBe('Sample Title')
        ->and($video->thumbnail_url)->toBe('https://example.com/thumbnail.jpg')
        ->and($video->description)->toBe('Sample description')
        ->and($video->duration)->toBe(123)
        ->and($video->band_name)->toBe('Sample Channel');
});
