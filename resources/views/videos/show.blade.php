<x-layouts.home>
    <x-slot name="title">Video Detail</x-slot>

    <div class="container mx-auto px-4 py-8">
        @if ($video)
            <div class="mx-auto max-w-4xl">
                {{-- Video Player using lite-youtube --}}
                <div class="mb-8">
                    <lite-youtube videoid="{{ $video->id_youtube }}" playlabel="{{ $video->title }}"
                        params="rel=0&modestbranding=1" class="w-full"></lite-youtube>
                </div>

                {{-- Video Information --}}
                <div class="rounded-lg bg-white p-6 shadow-md dark:bg-gray-800">
                    <h1 class="mb-4 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $video->title }}
                    </h1>

                    <div class="mb-6 flex flex-wrap gap-4 text-sm text-gray-600 dark:text-gray-400">
                        @if ($video->duration)
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                <span>{{ $video->getDurationInMinutesAndSeconds() }}</span>
                            </div>
                        @endif

                        @if ($video->band_name)
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3">
                                    </path>
                                </svg>
                                <span class="font-medium">{{ $video->band_name }}</span>
                            </div>
                        @endif

                        @if ($video->region)
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                                <span>{{ $video->region }}</span>
                            </div>
                        @endif
                    </div>

                    @if ($video->description)
                        <div class="border-t border-gray-200 pt-6 dark:border-gray-700">
                            <h2 class="mb-3 text-xl font-semibold text-gray-900 dark:text-white">
                                Descripción
                            </h2>
                            <p class="text-gray-700 dark:text-gray-300">
                                {{ $video->description }}
                            </p>
                        </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="mt-8 flex gap-4">
                        <a href="{{ route('videos.index') }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-gray-600 px-6 py-3 text-white transition-colors hover:bg-gray-700">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18">
                                </path>
                            </svg>
                            Volver a Videos
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="py-12 text-center">
                <svg class="mx-auto mb-4 h-16 w-16 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                    </path>
                </svg>
                <p class="text-lg text-gray-600 dark:text-gray-400">Video no encontrado</p>
                <a href="{{ route('videos.index') }}"
                    class="mt-4 inline-block text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    Volver a la lista de videos
                </a>
            </div>
        @endif
    </div>


    {{-- Custom script for fullscreen on play --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const liteYoutube = document.querySelector('lite-youtube');

            if (liteYoutube) {
                // Listen for when the lite-youtube element is clicked
                liteYoutube.addEventListener('click', function() {
                    // Wait a bit for the iframe to be created, then enter fullscreen
                    setTimeout(() => {
                        const iframe = liteYoutube.querySelector('iframe');
                        if (iframe) {
                            enterFullscreen(iframe);
                        }
                    }, 100);
                });
            }
        });

        function enterFullscreen(element) {
            if (element.requestFullscreen) {
                element.requestFullscreen();
            } else if (element.webkitRequestFullscreen) {
                /* Safari */
                element.webkitRequestFullscreen();
            } else if (element.msRequestFullscreen) {
                /* IE11 */
                element.msRequestFullscreen();
            } else if (element.mozRequestFullScreen) {
                /* Firefox */
                element.mozRequestFullScreen();
            }
        }

        // Optional: Exit fullscreen when pressing Escape
        document.addEventListener('fullscreenchange', handleFullscreenChange);
        document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
        document.addEventListener('mozfullscreenchange', handleFullscreenChange);
        document.addEventListener('MSFullscreenChange', handleFullscreenChange);

        function handleFullscreenChange() {
            if (!document.fullscreenElement &&
                !document.webkitFullscreenElement &&
                !document.mozFullScreenElement &&
                !document.msFullscreenElement) {
                // User exited fullscreen, you can add custom logic here if needed
                console.log('Exited fullscreen');
            }
        }
    </script>
</x-layouts.home>
