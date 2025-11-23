@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl p-8 border border-purple-200">
            
            {{-- Títulos Dinámicos --}}
            <h1 class="text-4xl font-extrabold text-gray-900 mb-2">{{ $platformData['title'] }}</h1>
            <p class="text-xl text-gray-500 mb-8">{{ $platformData['subtitle'] }}</p>

            <div class="flex justify-end items-center mb-8">
                <a href="{{ route('courses.create') }}" class="inline-flex items-center px-6 py-4 bg-gradient-to-r from-green-500 to-green-600 border border-transparent rounded-2xl font-black text-white uppercase tracking-widest hover:from-green-600 hover:to-green-700 transition ease-in-out duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    ➕ Nuevo Curso
                </a>
            </div>

            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-6 mb-6 rounded-2xl shadow-sm" role="alert">
                    <p class="font-black text-lg">✅ Éxito</p>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Título
                            </th>
                            {{-- 🚨 Columna Creado por (solo para Superusuarios) 🚨 --}}
                            @if (auth()->user()->isAdminForCourses())
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Creado por
                                </th>
                            @endif
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Categoría
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($courses as $course)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $course->title }}
                                </td>
                                {{-- 🚨 Nombre del Creador (solo para Superusuarios) 🚨 --}}
                                @if (auth()->user()->isAdminForCourses())
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $course->user->name ?? 'Usuario Eliminado' }}
                                    </td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                        {{ $course->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <a href="{{ route('courses.edit', $course->slug) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 px-4 py-2 rounded-xl hover:bg-indigo-200 transition duration-200 mr-2">
                                        ✏️ Editar
                                    </a>

                                    <form action="{{ route('courses.destroy', $course->slug) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de que desea eliminar este curso? Esta acción es irreversible.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 bg-red-100 px-4 py-2 rounded-xl hover:bg-red-200 transition duration-200">
                                            🗑️ Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                {{-- Ajustamos el colspan para que cubra toda la tabla (3 columnas + 1 si es admin) --}}
                                <td colspan="{{ auth()->user()->isAdminForCourses() ? 4 : 3 }}" class="px-8 py-12 text-center text-gray-500 text-lg">
                                    📭 No has creado ningún curso todavía o no hay cursos en la plataforma.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Paginación --}}
            <div class="mt-8">
                {{ $courses->links() }}
            </div>

        </div>
    </div>
</div>
@endsection