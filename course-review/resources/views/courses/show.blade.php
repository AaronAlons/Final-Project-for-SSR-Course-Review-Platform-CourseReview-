<x-guest-layout>
    <div class="container mx-auto p-4 md:p-8">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
            
            <div class="p-6 md:p-8 border-b">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $course->title }}</h1>
                <p class="text-xl text-gray-600 mb-4">Por: {{ $course->instructor }}</p>
                
                <p class="text-gray-800 text-base leading-relaxed">
                    {{ $course->description }}
                </p>
            </div>

            <div class="p-6 md:p-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Reseñas</h2>

                @auth
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg border">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Deja tu reseña</h3>
                        <form method="POST" action="{{ route('reviews.store', $course) }}">
                            @csrf
                            
                            <div>
                                <x-input-label for="rating" :value="__('Calificación (del 1 al 5)')" />
                                <select name="rating" id="rating" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Elige una calificación</option>
                                    <option value="5">5 Estrellas</option>
                                    <option value="4">4 Estrellas</option>
                                    <option value="3">3 Estrellas</option>
                                    <option value="2">2 Estrellas</option>
                                    <option value="1">1 Estrella</option>
                                </select>
                                <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="comment" :value="__('Comentario')" />
                                <textarea id="comment" name="comment" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('comment') }}</textarea>
                                <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button>
                                    {{ __('Enviar Reseña') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                @endauth

                @guest
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200 text-center">
                        <p class="text-blue-800">
                            <a href="{{ route('login') }}" class="font-bold underline">Inicia sesión</a> o <a href="{{ route('register') }}" class="font-bold underline">regístrate</a> para dejar una reseña.
                        </p>
                    </div>
                @endguest


                <div class="space-y-4">
                    @forelse ($course->reviews as $review)
                        <div class="border p-4 rounded-lg shadow-sm bg-white">
                            <div class="flex justify-between items-center mb-1">
                                <h4 class="font-semibold text-gray-800">{{ $review->user->name }}</h4>
                                <span class="text-sm text-yellow-500 font-bold">{{ $review->rating }} / 5 Estrellas</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-2">
                                {{ $review->created_at->diffForHumans() }}
                            </p>
                            <p class="text-gray-700">
                                {{ $review->comment }}
                            </p>
                        </div>
                    @empty
                        <div class="border p-4 rounded-lg text-center text-gray-500">
                            <p>Este curso aún no tiene reseñas. ¡Sé el primero!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>