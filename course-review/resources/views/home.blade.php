<x-guest-layout>
    <div class="container mx-auto p-4">
        
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Nuestros Cursos</h1>

        @if($courses->isEmpty())
            <p class="text-gray-700">No hay cursos disponibles por el momento.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @foreach($courses as $course)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105">
                        <div class="p-6">
                            <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                                <a href="{{ route('courses.show', $course) }}" class="hover:text-indigo-600">
                                    {{ $course->title }}
                                </a>
                            </h2>
                            
                            <p class="text-gray-600 text-sm mb-4">
                                Por: {{ $course->instructor }}
                            </p>
                            
                            <p class="text-gray-700 mb-4">
                                {{ Str::limit($course->description, 100) }}
                            </p>
                            
                            <a href="{{ route('courses.show', $course) }}" class="inline-block text-indigo-500 font-semibold hover:text-indigo-700 transition duration-200">
                                Ver detalles &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
                
            </div>

            <div class="mt-8">
                {{ $courses->links() }}
            </div>
        @endif

    </div>
</x-guest-layout>