@extends('layouts.app') 

@section('content')
<header class="bg-gradient-to-r from-purple-900 via-purple-700 to-purple-900 py-20 text-white shadow-2xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-black mb-4 leading-tight tracking-tight">
            {{ $platformData['title'] }}
        </h1>
        <p class="text-xl opacity-90 font-light">
            {{ $platformData['subtitle'] }}
        </p>
        
        @guest
            <p class="mt-8">
                <a href="{{ route('register') }}" class="inline-block bg-white text-purple-700 hover:bg-purple-100 font-bold py-4 px-8 rounded-full transition duration-300 shadow-2xl hover:scale-105 transform">
                    🚀 ¡Empieza a Reseñar Hoy!
                </a>
            </p>
        @endguest
    </div>
</header>

<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Sección de Cursos Destacados --}}
        @if ($featuredCourses->count() > 0)
        <h2 class="text-4xl font-black text-gray-900 mb-10 border-l-4 border-yellow-400 pl-4 bg-gradient-to-r from-yellow-50 to-transparent py-2">
            ⭐ Cursos 5 Estrellas
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            @foreach ($featuredCourses as $course)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl border-2 border-yellow-400 hover:border-yellow-500">
                    
                    {{-- Imagen del Curso --}}
                    <a href="{{ route('courses.show', $course->slug) }}">
                        <img src="{{ $course->image_url ? Storage::url($course->image_url) : 'https://placehold.co/600x400/4C1D95/FFFFFF?text=Curso+Destacado' }}" 
                             alt="Imagen destacada de {{ $course->title }}"
                             class="w-full h-48 object-cover hover:scale-105 transition duration-300">
                    </a>
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 leading-tight">
                            {{ $course->title }}
                        </h3>
                        <p class="text-sm text-purple-600 font-semibold mb-4 bg-purple-50 px-3 py-1 rounded-full inline-block">
                            👨‍🏫 {{ $course->instructor }}
                        </p>
                        
                        {{-- Rating Promedio --}}
                        <div class="flex items-center text-yellow-500 mb-3">
                            <span class="font-bold text-lg mr-2">{{ number_format($course->reviews_avg_rating ?? 0, 1) }}</span>
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="text-lg">{{ $i <= round($course->reviews_avg_rating) ? '⭐' : '☆' }}</span>
                                @endfor
                            </div>
                            <span class="text-gray-500 text-sm ml-2">({{ $course->reviews_count }})</span>
                        </div>

                        <p class="text-gray-600 text-sm line-clamp-3 mb-4 leading-relaxed">
                            {{ Str::limit($course->description, 100) }}
                        </p>
                        <a href="{{ route('courses.show', $course->slug) }}" class="text-purple-600 hover:text-purple-800 font-bold text-sm inline-flex items-center group">
                            Ver Detalles 
                            <span class="ml-1 group-hover:ml-2 transition-all duration-200">→</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
        
        {{-- Sección de Todos los Cursos --}}
        <h2 class="text-4xl font-black text-gray-900 mt-10 mb-10 border-l-4 border-purple-500 pl-4 bg-gradient-to-r from-purple-50 to-transparent py-2">
            📚 Todos los Cursos
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($courses as $course)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl border border-gray-200 hover:border-purple-300">
                    
                    {{-- Imagen del Curso --}}
                    <a href="{{ route('courses.show', $course->slug) }}">
                        <img src="{{ $course->image_url ? Storage::url($course->image_url) : 'https://placehold.co/600x400/6B7280/FFFFFF?text=Curso+Sin+Imagen' }}" 
                             alt="Imagen destacada de {{ $course->title }}"
                             class="w-full h-48 object-cover hover:scale-105 transition duration-300">
                    </a>

                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 leading-tight">
                            {{ $course->title }}
                        </h3>
                        <p class="text-sm text-purple-600 font-semibold mb-4 bg-purple-50 px-3 py-1 rounded-full inline-block">
                            👨‍🏫 {{ $course->instructor }}
                        </p>
                        
                        {{-- Rating --}}
                        @if ($course->reviews_count > 0)
                            <div class="flex items-center text-yellow-500 mb-3">
                                <span class="font-bold text-lg mr-2">{{ number_format($course->reviews_avg_rating ?? 0, 1) }}</span>
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="text-lg">{{ $i <= round($course->reviews_avg_rating) ? '⭐' : '☆' }}</span>
                                    @endfor
                                </div>
                                <span class="text-gray-500 text-sm ml-2">({{ $course->reviews_count }})</span>
                            </div>
                        @else
                            <p class="text-gray-500 text-sm mb-3 bg-gray-100 px-3 py-2 rounded-lg">🌟 Sé el primero en reseñar</p>
                        @endif
                        
                        <p class="text-gray-600 text-sm line-clamp-3 mb-4 leading-relaxed">
                            {{ Str::limit($course->description, 100) }}
                        </p>
                        <a href="{{ route('courses.show', $course->slug) }}" class="text-purple-600 hover:text-purple-800 font-bold text-sm inline-flex items-center group">
                            Ver Detalles 
                            <span class="ml-1 group-hover:ml-2 transition-all duration-200">→</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">📝 No hay cursos disponibles en este momento.</p>
                </div>
            @endforelse
        </div>

        {{-- Paginación --}}
        <div class="mt-12 flex justify-center">
            {{ $courses->links() }}
        </div>
        
    </div>
</section>
@endsection