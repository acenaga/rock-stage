<x-layouts.home>
    <x-slot name="title">Home Video</x-slot>

    <div class="container mx-auto px-4 py-8">
        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-white">Videos de Rock</h1>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($videos as $video)
                <a href="{{ route('video.detail', ['video' => $video->id]) }}">
                    <div
                        class="overflow-hidden rounded-lg bg-white shadow-md transition-shadow duration-300 hover:shadow-xl dark:bg-gray-800">
                        {{-- Imagen del video --}}
                        <div class="relative aspect-video bg-gray-200 dark:bg-gray-700">
                            @if ($video->thumbnail)
                                <img src="{{ $video->thumbnail }}" alt="{{ $video->title }}"
                                    class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full w-full items-center justify-center text-gray-400">
                                    <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif

                            {{-- Duración --}}
                            @if ($video->duration)
                                <div class="absolute bottom-2 right-2 rounded bg-black/80 px-2 py-1 text-xs text-white">
                                    {{ $video->getDurationInMinutesAndSeconds() }}
                                </div>
                            @endif
                        </div>

                        {{-- Información del video --}}
                        <div class="p-4">
                            <h3 class="mb-2 line-clamp-2 text-lg font-semibold text-gray-900 dark:text-white"
                                title="{{ $video->title }}">
                                {{ $video->title }}
                            </h3>

                            <div class="space-y-1 text-sm text-gray-600 dark:text-gray-400">
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
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Mensaje cuando no hay videos --}}
        @if ($videos->isEmpty())
            <div class="py-12 text-center">
                <svg class="mx-auto mb-4 h-16 w-16 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                    </path>
                </svg>
                <p class="text-lg text-gray-600 dark:text-gray-400">No hay videos disponibles</p>
            </div>
        @endif
    </div>
</x-layouts.home>
