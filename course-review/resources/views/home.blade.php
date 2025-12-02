@extends('layouts.app') 

@section('content')
<header class="bg-gradient-to-r from-purple-900 via-purple-700 to-purple-900 py-20 text-white shadow-2xl relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-black mb-4 leading-tight tracking-tight">
            {{ $platformData['title'] }}
        </h1>
        <p class="text-xl opacity-90 font-light">
            {{ $platformData['subtitle'] }}
        </p>
        
        @guest
            <p class="mt-8">
                <a href="{{ route('register') }}" class="inline-block bg-white text-purple-700 hover:bg-purple-100 font-bold py-4 px-8 rounded-full transition duration-300 shadow-2xl hover:scale-105 transform">
                    🚀 ¡Empieza a Reseñar Hoy!
                </a>
            </p>
        @endguest
    </div>

    {{-- Botón flotante para ver código fuente --}}
    <button onclick="showSourceCode()" 
            class="absolute bottom-4 right-4 bg-white text-purple-700 hover:bg-purple-100 font-bold py-2 px-4 rounded-lg transition duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center space-x-2">
        <span>📄</span>
        <span>Código Fuente</span>
    </button>
</header>

<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Sección de Cursos Destacados --}}
        @if ($featuredCourses->count() > 0)
        <h2 class="text-4xl font-black text-gray-900 mb-10 border-l-4 border-yellow-400 pl-4 bg-gradient-to-r from-yellow-50 to-transparent py-2">
            ⭐ Cursos Destacados
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
            @forelse ($featuredCourses as $course)
                {{-- Tarjeta de Curso Destacado --}}
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl border-2 border-yellow-400 hover:border-yellow-500">
                    <div class="relative">
                        <img src="{{ $course->image_url ? Storage::url($course->image_url) : 'https://placehold.co/600x400/FACC15/4C1D95?text=Destacado' }}" 
                             alt="{{ $course->title }}" 
                             class="w-full h-40 object-cover hover:scale-105 transition duration-300">
                        <span class="absolute top-3 left-3 bg-yellow-400 text-yellow-900 text-xs font-black px-3 py-1 rounded-full uppercase tracking-wide shadow-lg">
                            ⭐ Destacado
                        </span>
                    </div>
                    <div class="p-6">
                        <span class="text-xs font-semibold text-purple-600 uppercase tracking-widest bg-purple-50 px-2 py-1 rounded-lg">{{ $course->category }}</span>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-3 mt-2 line-clamp-2 leading-tight">
                            {{ $course->title }}
                        </h3>
                        
                        {{-- Rating --}}
                        @if (isset($course->reviews_avg_rating))
                            <div class="flex items-center text-yellow-500 mb-3">
                                <span class="font-bold text-lg mr-2">{{ number_format($course->reviews_avg_rating, 1) }}</span>
                                <div class="flex">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="text-lg mx-0.5">{{ $i <= round($course->reviews_avg_rating) ? '⭐' : '☆' }}</span>
                                    @endfor
                                </div>
                                <span class="text-gray-500 text-sm ml-2">({{ $course->reviews_count }})</span>
                            </div>
                        @else
                            <p class="text-gray-500 text-sm mb-3 bg-gray-100 px-3 py-2 rounded-lg font-medium">🌟 Curso nuevo</p>
                        @endif

                        <p class="text-sm text-purple-600 font-semibold mb-4 bg-purple-50 px-3 py-1 rounded-full inline-block">
                            👨‍🏫 {{ $course->instructor }}
                        </p>
                        
                        <p class="text-gray-600 text-sm line-clamp-3 mb-4 leading-relaxed">
                            {{ Str::limit($course->description, 100) }}
                        </p>
                        <a href="{{ route('courses.show_public', $course->slug) }}" class="text-purple-600 hover:text-purple-800 font-bold text-sm inline-flex items-center group">
                            Ver Detalles 
                            <span class="ml-1 group-hover:ml-2 transition-all duration-200">→</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg bg-white p-8 rounded-2xl shadow-lg border border-gray-200">
                        📝 No hay cursos destacados disponibles en este momento.
                    </p>
                </div>
            @endforelse
        </div>
        @endif
        
        {{-- Sección de Todos los Cursos (Paginados) --}}
        <h2 class="text-4xl font-black text-gray-900 mb-10 border-l-4 border-purple-500 pl-4 bg-gradient-to-r from-purple-50 to-transparent py-2">
            📚 Todos los Cursos
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse ($courses as $course)
                {{-- Tarjeta de Curso Normal --}}
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl border border-gray-200 hover:border-purple-300">
                    <div class="relative">
                        <img src="{{ $course->image_url ? Storage::url($course->image_url) : 'https://placehold.co/600x400/4C1D95/FFFFFF?text=Curso+Online' }}" 
                             alt="{{ $course->title }}" 
                             class="w-full h-40 object-cover hover:scale-105 transition duration-300">
                    </div>
                    <div class="p-6">
                        <span class="text-xs font-semibold text-purple-600 uppercase tracking-widest bg-purple-50 px-2 py-1 rounded-lg">{{ $course->category }}</span>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-3 mt-2 line-clamp-2 leading-tight">
                            {{ $course->title }}
                        </h3>
                        
                        {{-- Rating --}}
                        @if (isset($course->reviews_avg_rating))
                            <div class="flex items-center text-yellow-500 mb-3">
                                <span class="font-bold text-lg mr-2">{{ number_format($course->reviews_avg_rating, 1) }}</span>
                                <div class="flex">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="text-lg mx-0.5">{{ $i <= round($course->reviews_avg_rating) ? '⭐' : '☆' }}</span>
                                    @endfor
                                </div>
                                <span class="text-gray-500 text-sm ml-2">({{ $course->reviews_count }})</span>
                            </div>
                        @else
                            <p class="text-gray-500 text-sm mb-3 bg-gray-100 px-3 py-2 rounded-lg font-medium">🌟 Sé el primero en reseñar</p>
                        @endif

                        <p class="text-sm text-purple-600 font-semibold mb-4 bg-purple-50 px-3 py-1 rounded-full inline-block">
                            👨‍🏫 {{ $course->instructor }}
                        </p>
                        
                        <p class="text-gray-600 text-sm line-clamp-3 mb-4 leading-relaxed">
                            {{ Str::limit($course->description, 100) }}
                        </p>
                        <a href="{{ route('courses.show_public', $course->slug) }}" class="text-purple-600 hover:text-purple-800 font-bold text-sm inline-flex items-center group">
                            Ver Detalles 
                            <span class="ml-1 group-hover:ml-2 transition-all duration-200">→</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg bg-white p-8 rounded-2xl shadow-lg border border-gray-200">
                        📭 No hay cursos disponibles para mostrar en este momento.
                    </p>
                </div>
            @endforelse
        </div>

        {{-- Paginación: USANDO $courses --}}
        @if ($courses->count() > 0)
            <div class="mt-12 flex justify-center">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</section>

{{-- Modal para mostrar el código fuente --}}
<div id="sourceCodeModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-2xl max-w-6xl w-full mx-4 max-h-[90vh] overflow-hidden">
        <div class="flex justify-between items-center bg-purple-600 text-white p-6">
            <h3 class="text-xl font-bold">📄 Código Fuente - home.blade.php</h3>
            <button onclick="closeSourceCode()" class="text-white hover:text-purple-200 text-2xl font-bold">
                &times;
            </button>
        </div>
        <div class="p-6 bg-gray-900 text-gray-300 font-mono text-xs overflow-auto max-h-[70vh]">
            <pre id="sourceCodeContent" class="whitespace-pre-wrap break-words"></pre>
        </div>
        <div class="bg-gray-100 px-6 py-4 flex justify-between items-center">
            <span class="text-sm text-gray-600">Total de líneas: <span id="lineCount">0</span></span>
            <div class="space-x-2">
                <button onclick="closeSourceCode()" class="bg-gray-600 text-white hover:bg-gray-700 font-bold py-2 px-4 rounded-lg transition duration-300">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Función para escapar HTML y mostrar el código fuente completo
function getPageSourceCode() {
    // Obtener todo el HTML de la página actual
    const htmlContent = document.documentElement.outerHTML;
    
    // Escapar caracteres HTML para mostrar como texto
    const escapedHtml = htmlContent
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
    
    return escapedHtml;
}

function showSourceCode() {
    const modal = document.getElementById('sourceCodeModal');
    const contentElement = document.getElementById('sourceCodeContent');
    const lineCountElement = document.getElementById('lineCount');
    
    // Obtener y mostrar el código fuente
    const sourceCode = getPageSourceCode();
    contentElement.innerHTML = sourceCode;
    
    // Contar líneas
    const lines = sourceCode.split('\n').length;
    lineCountElement.textContent = lines;
    
    // Mostrar modal
    modal.classList.remove('hidden');
}

function closeSourceCode() {
    document.getElementById('sourceCodeModal').classList.add('hidden');
}

function copySourceCode() {
    const sourceCode = getPageSourceCode();
    const unescapedCode = sourceCode
        .replace(/&amp;/g, '&')
        .replace(/&lt;/g, '<')
        .replace(/&gt;/g, '>')
        .replace(/&quot;/g, '"')
        .replace(/&#039;/g, "'");
    
    navigator.clipboard.writeText(unescapedCode).then(() => {
        alert('Código copiado al portapapeles');
    }).catch(err => {
        console.error('Error al copiar: ', err);
        alert('Error al copiar el código');
    });
}

// Cerrar modal con ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeSourceCode();
    }
});

// Cerrar modal haciendo click fuera del contenido
document.getElementById('sourceCodeModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeSourceCode();
    }
});
</script>

@endsection