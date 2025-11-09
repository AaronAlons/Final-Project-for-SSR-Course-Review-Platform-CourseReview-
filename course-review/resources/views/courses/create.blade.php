@extends('layouts.app') // Usar el layout principal de la aplicación

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Crear Nuevo Curso</h2>

            {{-- Formulario que apunta al método store del controlador --}}
            <form method="POST" action="{{ route('courses.store') }}">
                @csrf
                
                {{-- Título del Curso --}}
                <div class="mb-4">
                    <label for="title" class="block font-medium text-sm text-gray-700">Título</label>
                    <input id="title" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="title" value="{{ old('title') }}" required autofocus />
                    @error('title')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Slug (Identificador URL) --}}
                <div class="mb-4">
                    <label for="slug" class="block font-medium text-sm text-gray-700">Slug (URL Amigable)</label>
                    <input id="slug" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="slug" value="{{ old('slug') }}" required />
                    @error('slug')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Instructor --}}
                <div class="mb-4">
                    <label for="instructor" class="block font-medium text-sm text-gray-700">Instructor</label>
                    <input id="instructor" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="instructor" value="{{ old('instructor') }}" required />
                    @error('instructor')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                {{-- Descripción del Curso --}}
                <div class="mb-6">
                    <label for="description" class="block font-medium text-sm text-gray-700">Descripción</label>
                    <textarea id="description" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" name="description" rows="5" required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Guardar Curso
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection