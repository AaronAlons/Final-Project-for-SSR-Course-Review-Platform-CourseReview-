@extends('layouts.app') 

@section('content')
<div class="py-12 bg-gradient-to-br from-gray-50 to-purple-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- Sección de Información del Curso --}}
        <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl p-8 mb-10 border border-purple-200">
            
            {{-- Imagen del Curso --}}
            <div class="relative rounded-xl overflow-hidden mb-8 shadow-lg">
                <img src="{{ $course->image_url ? Storage::url($course->image_url) : 'https://placehold.co/600x400/4C1D95/FFFFFF?text=Curso+Sin+Imagen' }}" 
                     alt="Imagen destacada de {{ $course->title }}"
                     class="w-full h-80 object-cover">
            </div>

            <h1 class="text-5xl font-black text-gray-900 mb-4 leading-tight">
                {{ $course->title }}
            </h1>
            <p class="text-2xl text-purple-600 font-bold mb-6 bg-purple-50 px-4 py-2 rounded-xl inline-block">
                👨‍🏫 Instructor: {{ $course->instructor }}
            </p>
            
            {{-- Rating --}}
            @if (isset($course->reviews_avg_rating))
                <div class="flex items-center text-yellow-500 mb-8 bg-yellow-50 px-6 py-4 rounded-2xl">
                    <span class="text-4xl font-black mr-3">{{ number_format($course->reviews_avg_rating, 1) }}</span>
                    <span class="text-gray-600 text-lg mr-4">/ 5</span>
                    <div class="flex space-x-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="text-2xl">{{ $i <= round($course->reviews_avg_rating) ? '⭐' : '☆' }}</span>
                        @endfor
                    </div>
                </div>
            @endif

            <div class="prose max-w-none text-gray-700">
                <h2 class="text-3xl font-black border-b-2 border-purple-500 pb-3 mb-6 text-gray-800">
                    📖 Descripción
                </h2>
                <p class="text-lg leading-relaxed bg-gray-50 p-6 rounded-xl">{{ $course->description }}</p>
            </div>
            
            {{-- Información Adicional --}}
            @if ($course->modules_count)
                <div class="mt-8 p-6 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-2xl shadow-lg border-l-4 border-purple-300">
                    <h3 class="text-2xl font-black mb-2">🏗️ Estructura del Curso</h3>
                    <p class="text-lg opacity-90">Este curso consta de <span class="font-black text-2xl">{{ $course->modules_count }}</span> módulos de contenido.</p>
                </div>
            @endif

        </div>

        {{-- Contenedor de Reseñas y Formulario --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Columna 1: Formulario de Reseña --}}
            <div class="lg:col-span-1 bg-white p-8 shadow-2xl rounded-2xl h-fit border border-purple-200">
                <h2 class="text-2xl font-black text-gray-800 mb-6 border-b-2 border-purple-500 pb-3">
                    💬 Deja tu Reseña
                </h2>
                
                {{-- Mensaje de Éxito --}}
                @if (session('success'))
                    <div class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-2xl mb-6 shadow-sm">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                @guest
                    <p class="text-gray-600 text-center bg-gray-100 p-4 rounded-xl">
                        <a href="{{ route('login') }}" class="text-purple-600 font-bold hover:text-purple-800 underline">Inicia sesión</a> para dejar tu reseña.
                    </p>
                @else
                    @if (! $course->reviews->contains('user_id', auth()->id()))
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        
                        {{-- Rating --}}
                        <div class="mb-6">
                            <label for="rating" class="block font-bold text-sm text-gray-700 mb-3">⭐ Calificación</label>
                            <select id="rating" name="rating" required class="block w-full border-2 border-gray-300 rounded-xl shadow-sm p-3 focus:border-purple-500 focus:ring-purple-500 transition duration-200">
                                <option value="">Selecciona una calificación</option>
                                @for ($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} Estrella{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                            @error('rating')
                                <p class="text-sm text-red-600 mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Comentario --}}
                        <div class="mb-6">
                            <label for="content" class="block font-bold text-sm text-gray-700 mb-3">📝 Comentario</label>
                            <textarea id="content" name="content" rows="4" required 
                                      class="block w-full border-2 border-gray-300 rounded-xl shadow-sm p-3 focus:border-purple-500 focus:ring-purple-500 transition duration-200" 
                                      placeholder="¿Qué te pareció el curso?">{{ old('content') }}</textarea>
                            @error('content') 
                                <p class="text-sm text-red-600 mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        @error('review_error')
                            <div class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-2xl mb-6">
                                ❌ {{ $message }}
                            </div>
                        @enderror
                        
                        <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-purple-700 text-white font-bold py-4 px-6 rounded-xl hover:from-purple-700 hover:to-purple-800 transition duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            📤 Enviar Reseña
                        </button>
                    </form>
                    @else
                        <div class="p-6 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-2xl text-center shadow-sm">
                            ✅ Ya has dejado una reseña para este curso. ¡Gracias!
                        </div>
                    @endif
                @endguest
            </div>

            {{-- Columna 2: Listado de Reseñas --}}
            <div class="lg:col-span-2 bg-white p-8 shadow-2xl rounded-2xl border border-purple-200">
                <h2 class="text-2xl font-black text-gray-800 mb-8 border-b-2 border-purple-500 pb-3">
                    📋 Reseñas ({{ $course->reviews->count() }})
                </h2>

                <div class="space-y-6">
                    @forelse ($course->reviews as $review)
                        <div class="border-b border-gray-200 pb-6 last:border-b-0 last:pb-0">
                            <div class="flex justify-between items-center mb-3">
                                <span class="font-bold text-gray-900 text-lg">{{ $review->user->name }}</span>
                                <div class="flex text-yellow-500 text-lg">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="mx-0.5">{{ $i <= $review->rating ? '⭐' : '☆' }}</span>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-700 text-lg leading-relaxed bg-gray-50 p-4 rounded-xl">"{{ $review->content }}"</p>
                            <p class="text-sm text-gray-500 mt-3 font-medium">📅 Publicado el {{ $review->created_at->format('d/m/Y') }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center text-lg py-8 bg-gray-100 rounded-xl">📝 Sé el primero en reseñar este curso.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection