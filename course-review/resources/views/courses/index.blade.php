@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl p-8 border border-purple-200">
            
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-black text-gray-800">🎓 Administración de Cursos</h2>
                
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

            <div class="overflow-x-auto rounded-2xl shadow-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-purple-500 to-purple-600">
                        <tr>
                            <th scope="col" class="px-8 py-4 text-left text-lg font-black text-white uppercase tracking-wider">
                                📝 Título
                            </th>
                            <th scope="col" class="px-8 py-4 text-left text-lg font-black text-white uppercase tracking-wider">
                                👨‍🏫 Instructor
                            </th>
                            <th scope="col" class="px-8 py-4 text-right text-lg font-black text-white uppercase tracking-wider">
                                ⚡ Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($courses as $course)
                            <tr class="hover:bg-purple-50 transition duration-150">
                                {{-- Título --}}
                                <td class="px-8 py-6 whitespace-nowrap text-lg font-bold text-gray-900">
                                    <a href="{{ route('courses.show', $course->slug) }}" class="text-purple-600 hover:text-purple-800 hover:underline">
                                        {{ $course->title }}
                                    </a>
                                </td>
                                {{-- Instructor --}}
                                <td class="px-8 py-6 whitespace-nowrap text-lg text-gray-700 font-medium">
                                    {{ $course->instructor }}
                                </td>
                                {{-- Acciones --}}
                                <td class="px-8 py-6 whitespace-nowrap text-right text-lg font-bold">
                                    <a href="{{ route('courses.edit', $course->slug) }}" class="text-purple-600 hover:text-purple-800 mr-6 bg-purple-100 px-4 py-2 rounded-xl hover:bg-purple-200 transition duration-200">
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
                                <td colspan="3" class="px-8 py-12 text-center text-gray-500 text-lg">
                                    📭 No has creado ningún curso todavía.
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