<?php

namespace App\Services;

use Google\Client;
use Google\Service\YouTube;
use Exception;

class YouTubeService
{
    protected $youtube;

    public function __construct()
    {
        $client = new Client();
        $client->setDeveloperKey(config('services.youtube.key'));
        $this->youtube = new YouTube($client);
    }

    public function getVideoDetails(string $videoId)
    {
        try {
            $response = $this->youtube->videos->listVideos('snippet,contentDetails', [
                'id' => $videoId
            ]);

            if (empty($response->items)) {
                return null;
            }

            $video = $response->items[0];
            $snippet = $video->getSnippet();

            return [
                'youtube_id'    => $videoId,
                'title'         => $snippet->getTitle(),
                'description'   => $snippet->getDescription(),
                'thumbnail' => $snippet->getThumbnails()->getHigh()->getUrl(),
                'duration'      => $this->parseDuration($video->getContentDetails()->getDuration()),
                'band_name'    => $snippet->getChannelTitle(),
            ];
        } catch (Exception $e) {
            report($e);
            return null;
        }
    }

    private function parseDuration($duration)
    {
        $interval = new \DateInterval($duration);
        $seconds = ($interval->h * 3600) + ($interval->i * 60) + $interval->s;
        return $seconds;
    }
}
