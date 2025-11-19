@props(['course'])

<a href="{{ route('courses.showPublic', $course->slug) }}" class="block">
    <div class="bg-white shadow-lg hover:shadow-xl transition duration-300 rounded-xl overflow-hidden h-full flex flex-col">
        
        {{-- Imagen del Curso (R8) --}}
        <div class="h-48 bg-gray-200 overflow-hidden">
            <img 
                src="{{ $course->image_url ?? 'https://placehold.co/600x400/3c3b3b/white?text=Curso' }}" 
                alt="Imagen del curso: {{ $course->title }}" 
                class="w-full h-full object-cover"
                onerror="this.onerror=null;this.src='https://placehold.co/600x400/3c3b3b/white?text=Curso';"
            >
        </div>

        <div class="p-5 flex flex-col flex-grow">
            {{-- Categoría (R8) --}}
            <span class="text-xs font-semibold text-indigo-600 uppercase tracking-wider mb-2">
                {{ $course->category }}
            </span>

            {{-- Título --}}
            <h4 class="text-xl font-bold text-gray-900 mb-2 leading-snug flex-grow">
                {{ $course->title }}
            </h4>
            
            {{-- Calificación Promedio (R5) --}}
            <div class="flex items-center mt-3">
                {{-- Usamos el componente de estrellas --}}
                <x-star-rating :rating="$course->average_rating" size="sm" />
                <span class="ml-2 text-sm font-semibold text-gray-700">
                    {{ number_format($course->average_rating, 1) }} ({{ $course->reviews_count ?? 0 }} reseñas)
                </span>
            </div>

            {{-- Descripción (R8) --}}
            <p class="text-sm text-gray-600 mt-3 line-clamp-3">
                {{ Str::limit($course->description, 100) }}
            </p>

            {{-- Módulos (R8) --}}
            <div class="mt-4 text-sm text-gray-500 border-t pt-3 flex justify-between items-center">
                <p>
                    <span class="font-semibold">{{ $course->modules_count }}</span> Módulos
                </p>
                <span class="text-xs text-gray-400">
                    Por: {{ $course->user->name ?? 'Admin' }}
                </span>
            </div>
        </div>
    </div>
</a>