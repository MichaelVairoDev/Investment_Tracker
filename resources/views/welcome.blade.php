<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Investment Tracker') }}</title>
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,{{ base64_encode(view('components.favicon')->render()) }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-white">
        <!-- Navbar -->
        <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <x-application-logo class="h-8 w-8" />
                        <span class="ml-2 text-xl font-bold text-gray-900">Investment Tracker</span>
                    </div>
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-semibold">
                                Iniciar Sesión
                            </a>
                            <a href="{{ route('register') }}" class="bg-indigo-600 text-white hover:bg-indigo-700 px-4 py-2 rounded-lg font-semibold transition duration-150">
                                Registrarse
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative pt-32 pb-24 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-white -z-10"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h1 class="text-5xl font-bold text-gray-900 leading-tight mb-6">
                            Administra tus inversiones de manera <span class="text-indigo-600">inteligente</span>
                        </h1>
                        <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                            Mantén un seguimiento preciso de tus inversiones, analiza tu rendimiento y toma decisiones informadas para maximizar tus ganancias.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            @auth
                                <a href="{{ route('dashboard') }}" class="bg-indigo-600 text-white hover:bg-indigo-700 px-8 py-4 rounded-xl font-semibold text-lg transition duration-150 inline-flex items-center">
                                    Ir al Dashboard
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="bg-indigo-600 text-white hover:bg-indigo-700 px-8 py-4 rounded-xl font-semibold text-lg transition duration-150 inline-flex items-center">
                                    Comenzar Gratis
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 px-8 py-4 rounded-xl font-semibold text-lg transition duration-150 inline-flex items-center">
                                    Iniciar Sesión
                                </a>
                            @endauth
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-0 bg-indigo-600 rounded-3xl rotate-3 opacity-10"></div>
                        <img src="{{ asset('home-preview.png') }}" alt="Investment Tracker Preview" class="relative rounded-2xl shadow-2xl">
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-24 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl mb-4">
                        Todo lo que necesitas para gestionar tus inversiones
                    </h2>
                    <p class="text-lg text-gray-600">
                        Herramientas poderosas y fáciles de usar para que puedas concentrarte en lo que realmente importa.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition duration-300">
                        <div class="bg-indigo-100 rounded-xl p-3 w-12 h-12 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">
                            Seguimiento en Tiempo Real
                        </h3>
                        <p class="text-gray-600">
                            Mantén un registro detallado de todas tus inversiones y observa su rendimiento en tiempo real.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition duration-300">
                        <div class="bg-indigo-100 rounded-xl p-3 w-12 h-12 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">
                            Análisis Detallado
                        </h3>
                        <p class="text-gray-600">
                            Obtén insights valiosos sobre el rendimiento de tu portafolio con gráficos y estadísticas detalladas.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition duration-300">
                        <div class="bg-indigo-100 rounded-xl p-3 w-12 h-12 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">
                            Gestión de Portafolios
                        </h3>
                        <p class="text-gray-600">
                            Organiza tus inversiones en diferentes portafolios y mantén un control total sobre tu estrategia.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-24 bg-indigo-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto">
                    <h2 class="text-3xl font-bold text-white sm:text-4xl mb-6">
                        Comienza a gestionar tus inversiones hoy mismo
                    </h2>
                    <p class="text-xl text-indigo-100 mb-8">
                        Únete a nuestra comunidad de inversores y toma el control de tu futuro financiero.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="bg-white text-indigo-600 hover:bg-indigo-50 px-8 py-4 rounded-xl font-semibold text-lg transition duration-150">
                                Ir al Dashboard
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="bg-white text-indigo-600 hover:bg-indigo-50 px-8 py-4 rounded-xl font-semibold text-lg transition duration-150">
                                Crear una cuenta gratuita
                            </a>
                            <a href="{{ route('login') }}" class="text-white border-2 border-white hover:bg-indigo-700 px-8 py-4 rounded-xl font-semibold text-lg transition duration-150">
                                Iniciar Sesión
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <div class="flex items-center mb-4">
                            <x-application-logo class="h-8 w-8" />
                            <span class="ml-2 text-xl font-bold">Investment Tracker</span>
                        </div>
                        <p class="text-gray-400">
                            Tu plataforma de gestión de inversiones
                        </p>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Producto</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition duration-150">Características</a></li>
                            <li><a href="#" class="hover:text-white transition duration-150">Precios</a></li>
                            <li><a href="#" class="hover:text-white transition duration-150">Guías</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Compañía</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition duration-150">Acerca de</a></li>
                            <li><a href="#" class="hover:text-white transition duration-150">Blog</a></li>
                            <li><a href="#" class="hover:text-white transition duration-150">Contacto</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Legal</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition duration-150">Privacidad</a></li>
                            <li><a href="#" class="hover:text-white transition duration-150">Términos</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} Investment Tracker. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
