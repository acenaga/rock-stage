<x-layouts.home>
    <x-slot name="title">Rock Stream</x-slot>

    {{-- Hero Section con Bienvenida --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-purple-900 via-purple-800 to-indigo-900">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="container relative mx-auto px-4 py-24 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-4xl text-center">
                <h1 class="mb-6 text-4xl font-bold text-white sm:text-5xl lg:text-6xl">
                    Bienvenido a <span
                        class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">Rock
                        Stream</span>
                </h1>
                <p class="mb-8 text-xl text-purple-100 sm:text-2xl">
                    Descubre los mejores videos de rock de todos los tiempos.
                    Una experiencia streaming diseñada para los verdaderos amantes del rock.
                </p>

                {{-- Descripción de la aplicación --}}
                <div class="mx-auto mb-12 max-w-2xl rounded-lg bg-white/10 p-6 backdrop-blur-sm sm:p-8">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                        <div class="text-center">
                            <div
                                class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-purple-500/20">
                                <svg class="h-8 w-8 text-purple-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z" />
                                </svg>
                            </div>
                            <h3 class="mb-2 text-lg font-semibold text-white">Música de Calidad</h3>
                            <p class="text-purple-200">Los mejores videos de rock en alta definición</p>
                        </div>
                        <div class="text-center">
                            <div
                                class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-pink-500/20">
                                <svg class="h-8 w-8 text-pink-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                </svg>
                            </div>
                            <h3 class="mb-2 text-lg font-semibold text-white">Curado por Expertos</h3>
                            <p class="text-purple-200">Selección cuidadosa de los clásicos del rock</p>
                        </div>
                        <div class="text-center">
                            <div
                                class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-indigo-500/20">
                                <svg class="h-8 w-8 text-indigo-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z" />
                                </svg>
                            </div>
                            <h3 class="mb-2 text-lg font-semibold text-white">Streaming Instantáneo</h3>
                            <p class="text-purple-200">Reproduce tus videos favoritos sin interrupciones</p>
                        </div>
                    </div>
                </div>

                {{-- Navegación de Autenticación --}}
                @guest
                    <div class="flex flex-col gap-4 sm:flex-row sm:justify-center">
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center justify-center rounded-lg bg-white px-8 py-4 text-lg font-semibold text-purple-900 shadow-lg transition-all hover:bg-purple-50 hover:shadow-xl sm:w-auto">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Iniciar Sesión
                        </a>

                        <a href="{{ route('register') }}"
                            class="inline-flex items-center justify-center rounded-lg bg-transparent px-8 py-4 text-lg font-semibold text-white shadow-lg ring-2 ring-white/50 transition-all hover:bg-white hover:text-purple-900 hover:shadow-xl sm:w-auto">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                </path>
                            </svg>
                            Crear Cuenta
                        </a>
                    </div>
                @else
                    <div class="text-center">
                        <p class="mb-4 text-lg text-purple-100">
                            ¡Hola {{ Auth::user()->name }}! 👋
                        </p>
                        <a href="{{ route('videos.index') }}"
                            class="inline-flex items-center justify-center rounded-lg bg-white px-8 py-4 text-lg font-semibold text-purple-900 shadow-lg transition-all hover:bg-purple-50 hover:shadow-xl">
                            <svg class="mr-3 h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8h5z" />
                            </svg>
                            Ver Videos
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </section>

    {{-- Sección de Destacados --}}
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="mb-4 text-3xl font-bold text-gray-900">Descubre el Rock</h2>
                <p class="mb-12 text-lg text-gray-600">
                    Explora nuestra colección curada de los mejores videos de rock de todas las épocas
                </p>
            </div>

            {{-- Llamada a la acción --}}
            <div class="text-center">
                <a href="{{ route('videos.index') }}"
                    class="inline-flex items-center rounded-lg bg-purple-600 px-8 py-4 text-lg font-semibold text-white shadow-lg transition-all hover:bg-purple-700 hover:shadow-xl">
                    Explorar Videos
                    <svg class="ml-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6">
                        </path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

</x-layouts.home>
