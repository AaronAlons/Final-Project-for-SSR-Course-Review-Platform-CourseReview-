@extends('layouts.app') 

@section('content')
<header class="bg-indigo-700 py-20 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-extrabold mb-4 leading-tight">
            {{ $platformData['title'] }}
        </h1>
        <p class="text-xl opacity-80">
            {{ $platformData['subtitle'] }}
        </p>
        
        @guest
            <p class="mt-6">
                <a href="{{ route('register') }}" class="inline-block bg-white text-indigo-700 hover:bg-indigo-100 font-bold py-3 px-6 rounded-full transition duration-300 shadow-xl">
                    ¡Empieza a Reseñar Hoy!
                </a>
            </p>
        @endguest
    </div>
</header>

<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 border-b-2 border-indigo-500 pb-2">
            Cursos Destacados
        </h2>

        {{-- Grid de Cursos (SSR: El HTML completo está aquí) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($courses as $course)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transition transform hover:scale-[1.02] duration-300">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 truncate">
                            {{ $course->title }}
                        </h3>
                        <p class="text-sm text-indigo-600 font-semibold mb-4">
                            Por: {{ $course->instructor }}
                        </p>
                        <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                            {{ Str::limit($course->description, 100) }}
                        </p>
                        <a href="{{ route('courses.show', $course->slug) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm inline-flex items-center">
                            Ver Detalles &raquo;
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 col-span-full">No hay cursos destacados disponibles en este momento.</p>
            @endforelse
        </div>
        
        @if ($courses->count() > 0)
            <div class="mt-10 text-center">
                <a href="{{ route('courses.list') }}" class="inline-block bg-gray-800 text-white hover:bg-gray-700 font-bold py-3 px-6 rounded-lg transition duration-300">
                    Ver Todos los Cursos (Próximamente)
                </a>
            </div>
        @endif
    </div>
</section>
@endsection