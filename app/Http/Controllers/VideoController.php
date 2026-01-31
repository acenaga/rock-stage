<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\View\View;

class VideoController extends Controller
{
    public function index(): View
    {
        $videos = Video::all();

        return view('videos.index', compact(['videos']));
    }

    public function show(Video $video): View
    {
        return view('videos.show', compact(['video']));
    }
}
