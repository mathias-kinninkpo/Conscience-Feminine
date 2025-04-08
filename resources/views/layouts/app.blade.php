<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="{{ asset('storage/images/logo.png') }}" />
    @yield('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>ONG Conscience Féminine - @yield('title')</title>
</head>

<body>
    <header>
        <nav class="bg-white border-gray-200 shadow-2xl">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="{{ asset('storage/images/logo.png') }}" class="h-10"
                        alt="Logo ONG Conscience Féminine" />
                </a>
                <button id="menu-toggle" type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="navbar-default" aria-expanded="false">
                    <span class="sr-only">Ouvrir le menu principal</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
                <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                    <ul
                        class="font-medium flex flex-col p-4 md:p-1 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white">
                        <li>
                            <a href="{{ route('home') }}"
                                class="block py-2 px-3 md:p-1 {{ request()->routeIs('home') ? 'text-white bg-blue-700 rounded-sm' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700' }}"
                                aria-current="{{ request()->routeIs('home') ? 'page' : '' }}">Accueil</a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}"
                                class="block py-2 px-3 md:p-1 {{ request()->routeIs('about') ? 'text-white bg-blue-700 rounded-sm' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700' }}"
                                aria-current="{{ request()->routeIs('about') ? 'page' : '' }}">À propos</a>
                        </li>
                        <li>
                            <a href="{{ route('activities') }}"
                                class="block py-2 px-3 md:p-1 {{ request()->routeIs('activities') ? 'text-white bg-blue-700 rounded-sm' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700' }}"
                                aria-current="{{ request()->routeIs('activities') ? 'page' : '' }}">Activités</a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}"
                                class="block py-2 px-3 md:p-1 {{ request()->routeIs('contact') ? 'text-white bg-blue-700 rounded-sm' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700' }}"
                                aria-current="{{ request()->routeIs('contact') ? 'page' : '' }}">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Contenu principal -->
    <main class="mt-5 pt-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="footer" class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- ONG Conscience Féminine Info -->
                <div>
                    <a href="{{ route('home') }}" class="flex items-center text-white no-underline">
                        <h3 class="text-2xl font-bold">ONG Conscience Féminine</h3>
                    </a>
                    <div class="pt-4 space-y-2">
                        <p>Cotonou, Bénin</p>
                        <p class="mt-2"><strong>Téléphone:</strong> <span>(+229) 01 95 20 48 48</span></p>
                        <p><strong>Email:</strong> <span>contact@consciencefeminine.org</span></p>
                    </div>
                </div>

                <!-- Liens utiles -->
                <div>
                    <h4 class="text-xl font-semibold mb-4">Liens utiles</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="flex items-center hover:underline"><span
                                    class="mr-2">›</span>Accueil</a></li>
                        <li><a href="{{ route('about') }}" class="flex items-center hover:underline"><span
                                    class="mr-2">›</span>À propos</a></li>
                        <li><a href="{{ route('contact') }}" class="flex items-center hover:underline"><span
                                    class="mr-2">›</span>Contact</a></li>
                        <li><a href="{{ route('activities') }}" class="flex items-center hover:underline"><span
                                    class="mr-2">›</span>Actualités</a></li>
                    </ul>
                </div>

                <!-- ONG Description and Social Links -->
                <div class="md:col-span-2">
                    <h4 class="text-xl font-semibold mb-4">Suivez-nous</h4>
                    <p class="mb-4">
                        ONG Conscience Féminine est dédiée à la promotion du leadership féminin, au bien-être des femmes
                        africaines et à la lutte contre les violences basées sur le genre. Conscience Féminine s’engage
                        pour l’accès à
                        l’éducation des jeunes filles et la réinsertion des victimes, tout en célébrant les leaders
                        africaines à travers les Trophées ASKE.
                    </p>
                    <p>Ensemble, bâtissons un avenir audacieux et inspirant.</p>
                    <div class="flex space-x-4 mt-4 text-2xl">
                        <a href="#" class="hover:text-blue-500"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="hover:text-red-500"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="hover:text-pink-500"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 text-center text-sm text-gray-400">
            <p>© <span>Copyright</span> <strong class="px-1 text-white">ONG Conscience Féminine</strong> <span>Tous
                    droits réservés</span></p>
        </div>
    </footer>

    <!-- Scripts -->
    @yield('scripts')
    <!-- Script pour gérer le menu responsive -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const navbar = document.getElementById('navbar-default');

            menuToggle.addEventListener('click', function() {
                navbar.classList.toggle('hidden');
            });
        });
    </script>
</body>

</html>
