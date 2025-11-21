@extends('layouts.app') 

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        {{-- Card principal con sombreado y bordes redondeados --}}
        <div class="bg-white overflow-hidden shadow-2xl sm:rounded-xl p-8 lg:p-10 border border-gray-100">
            
            {{-- Encabezado --}}
            <h2 class="text-3xl font-extrabold mb-8 text-gray-900">
                <i class="fas fa-plus-circle text-indigo-600 mr-2"></i> Crear Nuevo Curso
            </h2>

            {{-- Separador decorativo --}}
            <div class="h-1 bg-indigo-100 mb-8 rounded-full"></div>

            {{-- Formulario que apunta al método store del controlador --}}
            <form method="POST" action="{{ route('courses.store') }}">
                @csrf
                
                {{-- Contenedor de Formulario con espaciado uniforme --}}
                <div class="space-y-6">

                    {{-- Título del Curso --}}
                    <div>
                        <label for="title" class="block font-semibold text-sm text-gray-700 mb-1">Título del Curso</label>
                        <input id="title" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" 
                               type="text" 
                               name="title" 
                               value="{{ old('title') }}" 
                               placeholder="Ej: Desarrollo Web con Laravel y Vue"
                               required autofocus />
                        @error('title')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Categoría (Select) --}}
                    <div>
                        <label for="category" class="block font-semibold text-sm text-gray-700 mb-1">Categoría</label>
                        <select id="category" name="category" 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" 
                                required>
                            <option value="">— Selecciona una Categoría —</option>
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
                    <div>
                        <label for="image_url" class="block font-semibold text-sm text-gray-700 mb-1">URL de Imagen (Miniatura del Curso)</label>
                        <input id="image_url" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" 
                               type="url" 
                               name="image_url" 
                               value="{{ old('image_url') }}"
                               placeholder="https://ejemplo.com/imagen.jpg" />
                        @error('image_url')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Conteo de Módulos --}}
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

                    {{-- Nombre del Instructor --}}
                    <div>
                        <label for="instructor" class="block font-semibold text-sm text-gray-700 mb-1">Nombre del Instructor</label>
                        <input id="instructor" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" 
                               type="text" 
                               name="instructor" 
                               value="{{ old('instructor') }}" 
                               placeholder="Ej: Jane Doe"
                               required />
                        @error('instructor')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Descripción del Curso (Textarea) --}}
                    <div>
                        <label for="description" class="block font-semibold text-sm text-gray-700 mb-1">Descripción Detallada</label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="6" 
                                  placeholder="Describe brevemente de qué trata este curso, a quién está dirigido y qué aprenderán los estudiantes."
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" 
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div> {{-- Fin: space-y-6 --}}

                {{-- Botones de Acción --}}
                <div class="flex items-center justify-end mt-10 space-x-4">
                    {{-- Botón de Cancelar/Volver al Dashboard --}}
                    <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 font-semibold transition duration-150">
                        Cancelar
                    </a>

                    {{-- Botón de Guardar Curso con estilo moderno --}}
                    <button type="submit" class="inline-flex items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-full font-bold text-base text-white uppercase tracking-wider hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-4 focus:ring-indigo-300 transition ease-in-out duration-300 shadow-xl hover:shadow-2xl transform hover:scale-105">
                        <i class="fas fa-save mr-2"></i> Guardar Curso
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection