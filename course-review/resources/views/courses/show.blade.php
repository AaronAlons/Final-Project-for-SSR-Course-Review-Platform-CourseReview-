@extends('layouts.app') 

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- Sección de Información del Curso --}}
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 mb-10">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">
                {{ $course->title }}
            </h1>
            <p class="text-xl text-indigo-600 font-semibold mb-6">
                Instructor: {{ $course->instructor }}
            </p>
            
            {{-- Aquí podrías mostrar la calificación promedio --}}
            {{-- <div class="flex items-center text-yellow-500 mb-6">
                <span class="text-3xl font-bold">{{ number_format($course->average_rating ?? 0, 1) }}</span> / 5
            </div> --}}

            <div class="prose max-w-none text-gray-700">
                <h2 class="text-2xl font-bold border-b pb-2 mb-4 text-gray-800">Descripción</h2>
                <p class="text-lg leading-relaxed">{{ $course->description }}</p>
            </div>
        </div>

        {{-- Contenedor de Reseñas y Formulario --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Columna 1 y 2: Listado de Reseñas --}}
            <div class="lg:col-span-2 space-y-8">
                <h2 class="text-2xl font-bold text-gray-800 border-b pb-2 mb-4">Reseñas de Usuarios</h2>

                @forelse ($reviews as $review)
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center mb-3">
                            {{-- Aquí irían las estrellas de la calificación --}}
                            <div class="text-lg font-semibold text-gray-900">{{ $review->user->name }}</div>
                            <span class="ml-auto text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-700 italic border-l-4 border-indigo-500 pl-4">
                            "{{ $review->comment }}"
                        </p>
                    </div>
                @empty
                    <p class="text-gray-500">Sé el primero en reseñar este curso.</p>
                @endforelse
            </div>

            {{-- Columna 3: Formulario de Interacción (Tarea 3) --}}
            <div class="lg:col-span-1">
    <div class="bg-white p-6 rounded-lg shadow-xl sticky top-4">
        <h3 class="text-xl font-bold text-gray-800 mb-4">¡Deja tu Reseña!</h3>
        
        @guest
            <p class="text-gray-600 mb-4">Debes iniciar sesión para dejar una reseña.</p>
            <a href="{{ route('login') }}" class="w-full block text-center bg-indigo-600 text-white font-bold py-2 px-4 rounded hover:bg-indigo-700 transition">
                Iniciar Sesión
            </a>
        @endguest

        @auth
            {{-- Formulario para enviar la reseña --}}
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                
                {{-- Campo oculto para el ID del curso --}}
                <input type="hidden" name="course_id" value="{{ $course->id }}">

                {{-- Calificación (Rating) --}}
                <div class="mb-4">
                    <label for="rating" class="block font-medium text-sm text-gray-700">Tu Calificación (1-5)</label>
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
                    <label for="comment" class="block font-medium text-sm text-gray-700">Comentario</label>
                    <textarea id="comment" name="comment" rows="4" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="¿Qué te pareció el curso?">{{ old('comment') }}</textarea>
                    @error('comment')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Mensaje de error si ya reseñó --}}
                @error('review_error')
                    <div class="p-3 bg-red-100 border border-red-400 text-red-700 rounded mb-4">
                        {{ $message }}
                    </div>
                @enderror
                
                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded hover:bg-indigo-700 transition">
                    Enviar Reseña
                </button>
            </form>
        @endauth
    </div>
</div>

        </div>
    </div>
</div>
@endsection