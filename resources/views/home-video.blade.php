<x-layouts.home>
    <x-slot name="title">Home Video</x-slot>

    <div class="container mx-auto px-4 py-8">
        <ul>
            @foreach ($videos as $video)
                <li>{{ $video->title }}</li>
            @endforeach
        </ul>
    </div>
</x-layouts.home>
