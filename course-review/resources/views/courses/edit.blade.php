@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl p-8 border border-purple-200">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6 border-b-2 border-purple-500 pb-4">
                ✏️ Editar Curso: {{ $course->title }}
            </h2>

            <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- Grupo: Título, Instructor, Categoría y Módulos --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- Campo Título --}}
                    <div>
                        <label for="title" class="block text-lg font-bold text-gray-700 mb-2">📝 Título del Curso</label>
                        <input type="text" name="title" id="title" required 
                               class="mt-1 block w-full border-2 border-gray-300 rounded-2xl shadow-sm p-4 focus:border-purple-500 focus:ring-purple-500 transition duration-200"
                               value="{{ old('title', $course->title )}}"
                               placeholder="Ingresa el título del curso">
                        @error('title')
                            <p class="text-sm text-red-600 mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Campo Instructor --}}
                    <div>
                        <label for="instructor" class="block text-lg font-bold text-gray-700 mb-2">👨‍🏫 Nombre del Instructor</label>
                        <input type="text" name="instructor" id="instructor" required
                               class="mt-1 block w-full border-2 border-gray-300 rounded-2xl shadow-sm p-4 focus:border-purple-500 focus:ring-purple-500 transition duration-200"
                               value="{{ old('instructor', $course->instructor) }}"
                               placeholder="Nombre del instructor">
                        @error('instructor')
                            <p class="text-sm text-red-600 mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Campo Categoría --}}
                    <div>
                        <label for="category" class="block text-lg font-bold text-gray-700 mb-2">🏷️ Categoría</label>
                        <select name="category" id="category" required
                                class="mt-1 block w-full border-2 border-gray-300 rounded-2xl shadow-sm p-4 focus:border-purple-500 focus:ring-purple-500 transition duration-200">
                            <option value="">Selecciona una categoría</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $course->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-sm text-red-600 mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Campo Módulos --}}
                    <div>
                        <label for="modules_count" class="block text-lg font-bold text-gray-700 mb-2">📚 Número de Módulos</label>
                        <input id="modules_count" 
                               class="w-full border-2 border-gray-300 rounded-2xl shadow-sm p-4 focus:ring-purple-500 focus:border-purple-500 transition duration-200" 
                               type="number" 
                               name="modules_count" 
                               value="{{ old('modules_count', $course->modules_count) }}" 
                               min="1" 
                               required 
                               placeholder="Cantidad de módulos" />
                        @error('modules_count')
                            <p class="text-sm text-red-600 mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Campo para Subir Imagen (image_file) --}}
                <div class="mb-8">
                    <label for="image_file" class="block text-lg font-bold text-gray-700 mb-4">🖼️ Imagen del Curso (Opcional)</label>
                    <div class="relative">
                        <input type="file" name="image_file" id="image_file" 
                            class="block w-full text-lg text-gray-500 file:mr-6 file:py-4 file:px-6 file:rounded-2xl file:border-0 file:text-lg file:font-bold file:bg-gradient-to-r file:from-purple-500 file:to-purple-600 file:text-white hover:file:from-purple-600 hover:file:to-purple-700 border-2 border-gray-300 rounded-2xl p-4 focus:outline-none focus:ring-4 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 shadow-sm"
                            accept="image/*">
                    </div>
                    <p class="text-sm text-gray-500 mt-3 ml-2">📎 Sube una imagen (máx. 2MB). Si no subes, se usará una imagen de placeholder.</p>
                    @error('image_file')
                        <p class="text-sm text-red-600 mt-3 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Imagen actual si existe --}}
                @if ($course->image_url)
                    <div class="mt-6 p-6 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-300">
                        <p class="text-lg font-bold text-gray-700 mb-4">🖼️ Imagen Actual:</p>
                        <div class="flex items-center space-x-6">
                            <img src="{{ Storage::url($course->image_url) }}" 
                                 alt="Imagen actual del curso" 
                                 class="h-32 w-48 object-cover rounded-xl shadow-lg border-2 border-purple-300">
                            <div class="text-sm text-gray-600">
                                <p class="font-semibold">📏 Tamaño actual</p>
                                <p>🔄 Para cambiar, selecciona una nueva imagen arriba</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                {{-- Campo Descripción --}}
                <div class="mb-6">
                    <label for="description" class="block text-lg font-bold text-gray-700 mb-2">📄 Descripción del Curso</label>
                    <textarea name="description" id="description" rows="6" required
                              class="mt-1 block w-full border-2 border-gray-300 rounded-2xl shadow-sm p-4 focus:border-purple-500 focus:ring-purple-500 transition duration-200"
                              placeholder="Describe el contenido y objetivos del curso">{{ old('description', $course->description) }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-600 mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones de Acción --}}
                <div class="flex items-center justify-end border-t-2 border-gray-200 pt-6">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 font-bold mr-6 px-6 py-3 rounded-xl hover:bg-gray-100 transition duration-200 ease-in-out border-2 border-gray-300">
                        ↩️ Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-purple-700 border border-transparent rounded-2xl font-black text-white uppercase tracking-wider hover:from-purple-700 hover:to-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-500 transition ease-in-out duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                        💾 Actualizar Curso
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection