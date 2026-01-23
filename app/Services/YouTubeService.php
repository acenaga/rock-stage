<?php

namespace App\Services;

use Exception;
use Google\Client;
use Google\Service\YouTube;

class YouTubeService
{
    protected YouTube $youtube;

    public function __construct()
    {
        $client = new Client;
        $client->setDeveloperKey(config('services.youtube.key'));
        $this->youtube = new YouTube($client);
    }

    public function getVideoDetails(?string $videoId): ?array
    {
        if (! is_string($videoId) || trim($videoId) === '') {
            return null;
        }

        try {
            $response = $this->youtube->videos->listVideos('snippet,contentDetails', [
                'id' => $videoId,
            ]);

            if (empty($response->items)) {
                return null;
            }

            $video = $response->items[0];
            $snippet = $video->getSnippet();

            return [
                'youtube_id' => $videoId,
                'title' => $snippet->getTitle(),
                'description' => $snippet->getDescription(),
                'thumbnail_url' => $snippet->getThumbnails()->getHigh()->getUrl(),
                'duration' => $this->parseDuration($video->getContentDetails()->getDuration()),
                'band_name' => $snippet->getChannelTitle(),
            ];
        } catch (Exception $e) {
            report($e);

            return null;
        }
    }

    private function parseDuration(string $duration): int
    {
        try {
            $interval = new \DateInterval($duration);
        } catch (Exception) {
            return 0;
        }

        $seconds = ($interval->h * 3600) + ($interval->i * 60) + $interval->s;

        return $seconds;
    }
}
