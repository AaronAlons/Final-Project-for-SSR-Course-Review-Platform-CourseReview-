@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        {{-- Contenedor principal con estilo de tarjeta --}}
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-2">
                ✏️ Editar Curso: {{ $course->title }}
            </h2>

            {{-- 🚨 RUTA CRÍTICA: Debe apuntar a 'courses.update' y usar el método PATCH 🚨 --}}
            <form action="{{ route('courses.update', $course) }}" method="POST">
                @csrf
                @method('PATCH') {{-- **IMPORTANTE** para que Laravel use el método update --}}

                {{-- Grupo: Título, Instructor y Categoría --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- Campo Título --}}
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Título del Curso</label>
                        <input type="text" name="title" id="title" required 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               value="{{ old('title', $course->title) }}">
                        @error('title')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Campo Instructor --}}
                    <div>
                        <label for="instructor" class="block text-sm font-medium text-gray-700">Instructor</label>
                        <input type="text" name="instructor" id="instructor" required 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               value="{{ old('instructor', $course->instructor) }}">
                        @error('instructor')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Campo Categoría (Ocupa toda la fila en móvil, media fila en desktop) --}}
                    <div class="md:col-span-1">
                        <label for="category" class="block text-sm font-medium text-gray-700">Categoría</label>
                        <select name="category" id="category" required 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @php
                                // Definimos las categorías aquí, aunque idealmente vienen del controlador
                                $categories = ['Programacion', 'Lenguajes', 'Ofimatica', 'Diseño', 'Marketing', 'Hardware'];
                            @endphp
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $course->category) == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Campo URL de Imagen --}}
                    <div class="md:col-span-1">
                        <label for="image_url" class="block text-sm font-medium text-gray-700">URL de Imagen (Miniatura)</label>
                        <input type="url" name="image_url" id="image_url" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               value="{{ old('image_url', $course->image_url) }}"
                               placeholder="Ej: https://via.placeholder.com/600x400">
                        @error('image_url')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Campo Descripción (Ocupa todo el ancho) --}}
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción Detallada del Curso</label>
                    <textarea name="description" id="description" rows="5" required 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                              placeholder="Describe el contenido, objetivos y a quién va dirigido el curso.">{{ old('description', $course->description) }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Módulos (Ocupa todo el ancho) --}}
                <div>
                        <label for="modules_count" class="block font-semibold text-sm text-gray-700 mb-1">Número de Módulos</label>
                        <input id="modules_count" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" 
                               type="number" 
                               name="modules_count" 
                               value="{{ old('modules_count', 1) }}" 
                               min="1" required />
                        @error('modules_count')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                {{-- Botones de Acción --}}
                <div class="flex items-center justify-end border-t pt-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium mr-4 px-4 py-2 rounded-md hover:bg-gray-100 transition duration-150 ease-in-out">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-wider hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                        💾 Actualizar Curso
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection