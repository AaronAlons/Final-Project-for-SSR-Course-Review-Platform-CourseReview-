@extends('layouts.app') 

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- Sección de Información del Curso --}}
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 mb-10">
            
            {{-- Imagen del Curso --}}
            <img src="{{ $course->image_url ? Storage::url($course->image_url) : 'https://placehold.co/600x400/D1D5DB/1F2937?text=Curso+Sin+Imagen' }}" 
                 alt="Imagen destacada de {{ $course->title }}"
                 class="w-full h-64 object-cover rounded-lg mb-6 shadow-md">

            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">
                {{ $course->title }}
            </h1>
            <p class="text-xl text-indigo-600 font-semibold mb-6">
                Instructor: {{ $course->instructor }}
            </p>
            
            {{-- Aquí podrías mostrar la calificación promedio --}}
            {{-- Usamos $course->reviews_avg_rating (cargado por el controlador) --}}
            @if (isset($course->reviews_avg_rating))
                <div class="flex items-center text-yellow-500 mb-6">
                    <span class="text-3xl font-bold mr-2">{{ number_format($course->reviews_avg_rating, 1) }}</span> / 5
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="w-6 h-6 fill-current {{ $i <= round($course->reviews_avg_rating) ? 'text-yellow-500' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 7.41l6.572-.955L10 1l2.939 5.455 6.572.955-4.756 4.135 1.123 6.545z"/>
                        </svg>
                    @endfor
                </div>
            @endif

            <div class="prose max-w-none text-gray-700">
                <h2 class="text-2xl font-bold border-b pb-2 mb-4 text-gray-800">Descripción</h2>
                <p class="text-lg leading-relaxed">{{ $course->description }}</p>
            </div>
            
             {{-- Información Adicional --}}
            @if ($course->modules_count)
                <div class="mt-6 p-4 bg-indigo-50 border-l-4 border-indigo-500 rounded-lg">
                    <h3 class="text-xl font-bold text-indigo-800">Estructura del Curso</h3>
                    <p class="text-indigo-700">Este curso consta de {{ $course->modules_count }} módulos de contenido.</p>
                </div>
            @endif


        </div>

        {{-- Contenedor de Reseñas y Formulario --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Columna 1: Formulario de Reseña --}}
            <div class="lg:col-span-1 bg-white p-6 shadow-xl rounded-lg h-fit">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Deja tu Reseña</h2>
                
                {{-- Mensaje de Éxito --}}
                @if (session('success'))
                    <div class="p-3 bg-green-100 border border-green-400 text-green-700 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @guest
                    <p class="text-gray-600">
                        <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:text-indigo-800">Inicia sesión</a> para dejar tu reseña.
                    </p>
                @else
                    {{-- Formulario para enviar la reseña --}}
                    {{-- Si el usuario ya reseñó, no mostramos el formulario --}}
                    @if (! $course->reviews->contains('user_id', auth()->id()))
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        {{-- Campo oculto para el ID del curso --}}
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        
                        {{-- Rating --}}
                        <div class="mb-4">
                            <label for="rating" class="block font-medium text-sm text-gray-700">Calificación</label>
                            <select id="rating" name="rating" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Selecciona una calificación</option>
                                @for ($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} Estrellas</option>
                                @endfor
                            </select>
                            @error('rating')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Comentario --}}
                        <div class="mb-4">
                            <label for="content" class="block font-medium text-sm text-gray-700">Comentario</label>
                            <textarea id="content" name="content" rows="4" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="¿Qué te pareció el curso?">{{ old('content') }}</textarea>
                            @error('content') <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Mensaje de error si ya reseñó (generalmente manejado en el controlador) --}}
                        @error('review_error')
                            <div class="p-3 bg-red-100 border border-red-400 text-red-700 rounded mb-4">
                                {{ $message }}
                            </div>
                        @enderror
                        
                        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded hover:bg-indigo-700 transition">
                            Enviar Reseña
                        </button>
                    </form>
                    @else
                        <div class="p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded mb-4">
                            Ya has dejado una reseña para este curso. ¡Gracias!
                        </div>
                    @endif
                @endguest
            </div>

            {{-- Columna 2: Listado de Reseñas --}}
            <div class="lg:col-span-2 bg-white p-6 shadow-xl rounded-lg">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">
                    Reseñas ({{ $course->reviews->count() }})
                </h2>

                <div class="space-y-6">
                    @forelse ($course->reviews as $review)
                        <div class="border-b pb-4 last:border-b-0">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-semibold text-gray-900">{{ $review->user->name }}</span>
                                <div class="flex text-yellow-500">
                                    {{-- Mostrar estrellas --}}
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 fill-current {{ $i <= $review->rating ? 'text-yellow-500' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 7.41l6.572-.955L10 1l2.939 5.455 6.572.955-4.756 4.135 1.123 6.545z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-700 italic">"{{ $review->content }}"</p>
                            <p class="text-xs text-gray-500 mt-2">Publicado el {{ $review->created_at->format('d/m/Y') }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500">Sé el primero en reseñar este curso.</p>
                    @endforelse
                </div>
            </div>
        </div> {{-- Fin del Contenedor de Reseñas y Formulario --}}


    </div>
</div>
@endsection