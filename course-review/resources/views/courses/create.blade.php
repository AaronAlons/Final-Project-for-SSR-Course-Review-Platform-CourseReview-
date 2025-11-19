@extends('layouts.app') 

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            
            <h2 class="text-3xl font-extrabold mb-8 text-gray-900 border-b pb-4">
                Crear Nuevo Curso
            </h2>

            {{-- Formulario que apunta al método store del controlador --}}
            <form method="POST" action="{{ route('courses.store') }}">
                @csrf
                
                {{-- Título del Curso --}}
                <div class="mb-6">
                    <label for="title" class="block font-medium text-sm text-gray-700">Título</label>
                    <input id="title" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                           type="text" 
                           name="title" 
                           value="{{ old('title') }}" 
                           required autofocus />
                    @error('title')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Categoría (Select) --}}
                <div class="mb-6">
                    <label for="category" class="block font-medium text-sm text-gray-700">Categoría</label>
                    <select id="category" name="category" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">Selecciona una Categoría</option>
                        {{-- Las categorías se pasan desde el controlador --}}
                        @if (isset($categories))
                            @foreach ($categories as $category)
                                <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('category')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- URL de Imagen --}}
                <div class="mb-6">
                    <label for="image_url" class="block font-medium text-sm text-gray-700">URL de Imagen (Opcional)</label>
                    <input id="image_url" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                           type="url" 
                           name="image_url" 
                           value="{{ old('image_url') }}" />
                    @error('image_url')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Conteo de Módulos --}}
                <div class="mb-6">
                    <label for="modules_count" class="block font-medium text-sm text-gray-700">Número de Módulos</label>
                    <input id="modules_count" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                           type="number" 
                           name="modules_count" 
                           value="{{ old('modules_count', 1) }}" 
                           min="1" required />
                    @error('modules_count')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nombre del Instructor --}}
                <div class="mb-4">
                    <label for="instructor" class="block font-medium text-sm text-gray-700">Nombre del Instructor</label>
                    <input id="instructor" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="instructor" value="{{ old('instructor') }}" required />
                    @error('instructor')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Descripción del Curso --}}
                <div class="mb-6">
                    <label for="description" class="block font-medium text-sm text-gray-700">Descripción</label>
                    <textarea id="description" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                              name="description" 
                              rows="5" 
                              required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-full font-semibold text-sm text-white uppercase tracking-wider hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-4 focus:ring-indigo-300 transition ease-in-out duration-150 shadow-lg">
                        Guardar Curso
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection