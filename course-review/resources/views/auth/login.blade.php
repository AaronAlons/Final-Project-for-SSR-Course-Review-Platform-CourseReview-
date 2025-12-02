<x-guest-layout>
    <div class="bg-gradient-to-br from-purple-50 to-white py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-2xl p-8 border border-purple-200">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-black text-gray-900 mb-2">🔐 Iniciar Sesión</h2>
                    <p class="text-gray-600">Bienvenido de vuelta</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-2xl shadow-sm" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-6">
                        <x-input-label for="email" :value="__('📧 Email')" class="text-lg font-bold text-gray-700" />
                        <x-text-input id="email" class="block mt-2 w-full border-2 border-gray-300 rounded-2xl p-4 focus:border-purple-500 focus:ring-purple-500 transition duration-200" 
                                    type="email" 
                                    name="email" 
                                    :value="old('email')" 
                                    required 
                                    autofocus 
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
                                    autocomplete="current-password"
                                    placeholder="Tu contraseña" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 font-bold" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-6 mb-6">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded border-2 border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500 transition duration-200" name="remember">
                            <span class="ms-3 text-sm text-gray-700 font-medium">{{ __('Recordar sesión') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <div class="space-y-2">
                            @if (Route::has('password.request'))
                                <a class="text-gray-600 hover:text-gray-900 font-bold text-sm rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-200 hover:bg-gray-100 px-3 py-2 block" 
                                   href="{{ route('password.request') }}">
                                    🔓 ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                            <a class="text-gray-600 hover:text-gray-900 font-bold text-sm rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-200 hover:bg-gray-100 px-3 py-2 block" 
                               href="{{ route('register') }}">
                                🚀 ¿No tienes cuenta? Regístrate
                            </a>
                        </div>

                        <x-primary-button class="ms-4 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 border-0 rounded-2xl font-black px-8 py-4 text-white uppercase tracking-wider transition ease-in-out duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            {{ __('Ingresar') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>