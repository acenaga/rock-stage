<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Http\Resources\VideoResource;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $videos = Video::query()->latest()->paginate(15);

        return VideoResource::collection($videos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVideoRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $video = Video::create($validated);

        return response()->json([
            'message' => 'Video created successfully',
            'data' => new VideoResource($video),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video): VideoResource
    {
        return new VideoResource($video);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVideoRequest $request, Video $video): JsonResponse
    {
        $validated = $request->validated();

        $video->update($validated);

        return response()->json([
            'message' => 'Video updated successfully',
            'data' => new VideoResource($video),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video): JsonResponse
    {
        $video->delete();

        return response()->json([
            'message' => 'Video deleted successfully',
        ], 204);
    }
}
