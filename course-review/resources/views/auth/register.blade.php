<x-guest-layout>
    <div class="bg-gradient-to-br from-purple-50 to-white py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl p-8 border border-purple-200">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-black text-gray-900 mb-2">🚀 Crear Cuenta</h2>
                    <p class="text-gray-600">Únete a nuestra comunidad de cursos</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-6">
                        <x-input-label for="name" :value="__('👤 Nombre')" class="text-lg font-bold text-gray-700" />
                        <x-text-input id="name" class="block mt-2 w-full border-2 border-gray-300 rounded-2xl p-4 focus:border-purple-500 focus:ring-purple-500 transition duration-200" 
                                    type="text" 
                                    name="name" 
                                    :value="old('name')" 
                                    required 
                                    autofocus 
                                    autocomplete="name"
                                    placeholder="Tu nombre completo" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 font-bold" />
                    </div>

                    <!-- Email Address -->
                    <div class="mb-6">
                        <x-input-label for="email" :value="__('📧 Email')" class="text-lg font-bold text-gray-700" />
                        <x-text-input id="email" class="block mt-2 w-full border-2 border-gray-300 rounded-2xl p-4 focus:border-purple-500 focus:ring-purple-500 transition duration-200" 
                                    type="email" 
                                    name="email" 
                                    :value="old('email')" 
                                    required 
                                    autocomplete="username"
                                    placeholder="tu@email.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 font-bold" />
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <x-input-label for="password" :value="__('🔒 Contraseña')" class="text-lg font-bold text-gray-700" />
                        <x-text-input id="password" class="block mt-2 w-full border-2 border-gray-300 rounded-2xl p-4 focus:border-purple-500 focus:ring-purple-500 transition duration-200"
                                    type="password"
                                    name="password"
                                    required 
                                    autocomplete="new-password"
                                    placeholder="Mínimo 8 caracteres" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 font-bold" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-8">
                        <x-input-label for="password_confirmation" :value="__('✅ Confirmar Contraseña')" class="text-lg font-bold text-gray-700" />
                        <x-text-input id="password_confirmation" class="block mt-2 w-full border-2 border-gray-300 rounded-2xl p-4 focus:border-purple-500 focus:ring-purple-500 transition duration-200"
                                    type="password"
                                    name="password_confirmation" 
                                    required 
                                    autocomplete="new-password"
                                    placeholder="Repite tu contraseña" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 font-bold" />
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a class="text-gray-600 hover:text-gray-900 font-bold text-sm rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-200 hover:bg-gray-100 px-4 py-2" 
                           href="{{ route('login') }}">
                            ← ¿Ya tienes cuenta?
                        </a>

                        <x-primary-button class="ms-4 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 border-0 rounded-2xl font-black px-8 py-4 text-white uppercase tracking-wider transition ease-in-out duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            {{ __('Registrarme') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>