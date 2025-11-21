@extends('layouts.app') 

@section('content')
<header class="bg-indigo-700 py-20 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-extrabold mb-4 leading-tight">
            {{ $platformData['title'] }}
        </h1>
        <p class="text-xl opacity-80">
            {{ $platformData['subtitle'] }}
        </p>
        
        @guest
            <p class="mt-6">
                <a href="{{ route('register') }}" class="inline-block bg-white text-indigo-700 hover:bg-indigo-100 font-bold py-3 px-6 rounded-full transition duration-300 shadow-xl">
                    ¡Empieza a Reseñar Hoy!
                </a>
            </p>
        @endguest
    </div>
</header>

<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Sección de Cursos Destacados (Solo si hay) --}}
        @if ($featuredCourses->count() > 0)
        <h2 class="text-3xl font-bold text-gray-800 mb-8 border-b-2 border-indigo-500 pb-2">
            ⭐ Cursos 5 Estrellas
        </h2>

        {{-- Grid de Cursos Destacados --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach ($featuredCourses as $course)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transition transform hover:scale-[1.02] duration-300 border-2 border-yellow-400">
                    
                    {{-- Imagen del Curso --}}
                    <a href="{{ route('courses.show', $course->slug) }}">
                        <img src="{{ $course->image_url ?? 'https://placehold.co/600x400/D1D5DB/1F2937?text=Curso+Destacado' }}" 
                             alt="Imagen destacada de {{ $course->title }}"
                             class="w-full h-48 object-cover">
                    </a>
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 truncate">
                            {{ $course->title }}
                        </h3>
                        <p class="text-sm text-indigo-600 font-semibold mb-4">
                            Por: {{ $course->instructor }}
                        </p>
                        
                        {{-- Rating Promedio y Conteo --}}
                        <div class="flex items-center text-yellow-500 mb-2">
                            <span class="font-bold mr-1">{{ number_format($course->reviews_avg_rating ?? 0, 1) }}</span>
                            <span class="text-gray-500 text-xs">({{ $course->reviews_count }} reseñas)</span>
                        </div>

                        <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                            {{ Str::limit($course->description, 100) }}
                        </p>
                        <a href="{{ route('courses.show', $course->slug) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm inline-flex items-center">
                            Ver Detalles &raquo;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
        
        {{-- Sección de Todos los Cursos (Paginados) --}}
        <h2 class="text-3xl font-bold text-gray-800 mt-6 mb-8 border-b-2 border-indigo-500 pb-2">
            Todos los Cursos
        </h2>

        {{-- Grid de Cursos (Paginado) --}}
        {{-- 🔥 CRÍTICO: Usamos $courses para el bucle y la paginación --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($courses as $course)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transition transform hover:scale-[1.02] duration-300">
                    
                    {{-- Imagen del Curso --}}
                    <a href="{{ route('courses.show', $course->slug) }}">
                        <img src="{{ $course->image_url ?? 'https://placehold.co/600x400/D1D5DB/1F2937?text=Curso+Sin+Imagen' }}" 
                             alt="Imagen destacada de {{ $course->title }}"
                             class="w-full h-48 object-cover">
                    </a>

                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 truncate">
                            {{ $course->title }}
                        </h3>
                        <p class="text-sm text-indigo-600 font-semibold mb-4">
                            Por: {{ $course->instructor }}
                        </p>
                        
                        {{-- Rating Promedio y Conteo --}}
                        @if ($course->reviews_count > 0)
                            <div class="flex items-center text-yellow-500 mb-2">
                                <span class="font-bold mr-1">{{ number_format($course->reviews_avg_rating ?? 0, 1) }}</span>
                                <span class="text-gray-500 text-xs">({{ $course->reviews_count }} reseñas)</span>
                            </div>
                        @else
                            <p class="text-gray-500 text-xs mb-2">Sin reseñas aún.</p>
                        @endif
                        
                        <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                            {{ Str::limit($course->description, 100) }}
                        </p>
                        <a href="{{ route('courses.show', $course->slug) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm inline-flex items-center">
                            Ver Detalles &raquo;
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 col-span-full">No hay cursos disponibles en este momento.</p>
            @endforelse
        </div>

        {{-- Paginación --}}
        <div class="mt-10">
            {{ $courses->links() }}
        </div>
        
    </div>
</section>
@endsection