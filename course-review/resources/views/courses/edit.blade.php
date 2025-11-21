@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        {{-- Contenedor principal con estilo de tarjeta --}}
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-2">
                ✏️ Editar Curso: {{ $course->title }}
            </h2>

            {{-- 🚨 CRÍTICO: Añadimos enctype="multipart/form-data" 🚨 --}}
            <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH') {{-- **IMPORTANTE** para que Laravel use el método update --}}

                {{-- Grupo: Título, Instructor, Categoría y Módulos --}}
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
                        <label for="instructor" class="block text-sm font-medium text-gray-700">Nombre del Instructor</label>
                        <input type="text" name="instructor" id="instructor" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               value="{{ old('instructor', $course->instructor) }}">
                        @error('instructor')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Campo Categoría --}}
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Categoría</label>
                        <select name="category" id="category" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecciona una categoría</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $course->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Campo Módulos --}}
                    <div>
                        <label for="modules_count" class="block text-sm font-medium text-gray-700">Número de Módulos</label>
                        <input id="modules_count" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" 
                               type="number" 
                               name="modules_count" 
                               value="{{ old('modules_count', $course->modules_count) }}" 
                               min="1" required />
                        @error('modules_count')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Campo para Subir Imagen (image_file) --}}
                <div class="mb-8">
                    <label for="image_file" class="block text-sm font-medium text-gray-700 mb-3">Imagen del Curso (Opcional)</label>
                    <div class="relative">
                        <input type="file" name="image_file" id="image_file" 
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                            accept="image/*">
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Sube una imagen (máx. 2MB). Si no subes, se usará una imagen de placeholder.</p>
                    @error('image_file')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                    {{-- Imagen actual si existe --}}
                    @if ($course->image_url)
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-700 mb-2">Imagen Actual:</p>
                            <img src="{{ Storage::url($course->image_url) }}" alt="Imagen actual del curso" class="h-32 w-48 object-cover rounded-md shadow-md">
                        </div>
                    @endif
                </div>
                
                {{-- Campo Descripción --}}
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción del Curso</label>
                    <textarea name="description" id="description" rows="5" required
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $course->description) }}</textarea>
                    @error('description')
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