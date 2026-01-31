<?php

namespace App\Jobs;

use App\Models\Video;
use App\Services\YouTubeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessYouTubeVideo implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Delete the job if its models no longer exist.
     */
    public bool $deleteWhenMissingModels = true;

    /**
     * The video model to process.
     */
    protected ?Video $video = null;

    /**
     * Create a new job instance.
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     */
    public function handle(YouTubeService $service): void
    {
        Log::info('Mensaje', ['video_debug' => $this->video]);

        if ($this->video === null) {
            return;
        }

        $youtubeId = trim((string) ($this->video->id_youtube ?? ''));

        if ($youtubeId === '') {
            $this->video->update(['status' => 'failed']);

            return;
        }

        $this->video->update(['status' => 'processing']);

        $data = $service->getVideoDetails($youtubeId);

        if ($data) {
            $this->video->update([
                'title' => $data['title'],
                'thumbnail_url' => $data['thumbnail_url'],
                'description' => $data['description'],
                'duration' => $data['duration'],
                'band_name' => $data['band_name'],
                'status' => 'completed',
            ]);
        } else {
            $this->video->update(['status' => 'failed']);
        }
    }
}
