<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ONG Conscience Féminine - Promotion du développement intellectuel et l'épanouissement des jeunes filles, futures leaders de demain">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('storage/images/logo.png') }}" />
    
    <title>ONG Conscience Féminine - @yield('title', 'Accueil')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --color-primary: #008B48;
            --color-primary-light: #33A86D;
            --color-primary-dark: #006B34;
            --color-secondary: #97BF0D;
            --color-secondary-light: #B2D23D;
            --color-secondary-dark: #7A9900;
            --color-tertiary: #920E7C;
            --color-tertiary-light: #B52999;
            --color-tertiary-dark: #700A5F;
        }
        
        body {
            font-family: 'Open Sans', sans-serif;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
        
        .btn-primary {
            background-color: var(--color-primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.3s;
            display: inline-block;
        }
        
        .btn-primary:hover {
            background-color: var(--color-primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .btn-secondary {
            background-color: var(--color-secondary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.3s;
            display: inline-block;
        }
        
        .btn-secondary:hover {
            background-color: var(--color-secondary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .btn-tertiary {
            background-color: var(--color-tertiary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.3s;
            display: inline-block;
        }
        
        .btn-tertiary:hover {
            background-color: var(--color-tertiary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .section-heading {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
            font-weight: 700;
            color: #333;
        }
        
        .section-heading:after {
            content: '';
            display: block;
            width: 70px;
            height: 4px;
            background: var(--color-primary);
            position: absolute;
            bottom: 0;
            left: 0;
        }
        
        .section-heading.text-center:after {
            left: 50%;
            transform: translateX(-50%);
        }
        
        .nav-link {
            position: relative;
            transition: all 0.3s;
        }
        
        .nav-link:hover {
            color: var(--color-primary);
        }
        
        .nav-link.active {
            color: var(--color-primary);
            font-weight: 600;
        }
        
        .nav-link.active:after {
            content: '';
            position: absolute;
            width: 100%;
            height: 3px;
            background-color: var(--color-primary);
            bottom: -5px;
            left: 0;
        }
    </style>
    
    @yield('styles')
</head>
<body class="antialiased">
    <!-- Header -->
    <header class="bg-white shadow-md">
        <!-- Top Bar -->
        <div class="bg-primary py-2 text-white">
            <div class="container mx-auto px-4 flex justify-between items-center">
                <div class="flex items-center text-sm">
                    <a href="mailto:contact@consciencefeminine.org" class="mr-4 hover:text-gray-200">
                        <i class="bi bi-envelope mr-1"></i> contact@consciencefeminine.org
                    </a>
                    <a href="tel:+22901952048" class="hover:text-gray-200">
                        <i class="bi bi-telephone mr-1"></i> (+229) 01 95 20 48 48
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="#" class="text-white hover:text-gray-200">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="text-white hover:text-gray-200">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="text-white hover:text-gray-200">
                        <i class="bi bi-twitter-x"></i>
                    </a>
                    <a href="#" class="text-white hover:text-gray-200">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Main Navigation -->
        <nav class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('storage/images/logo.png') }}" alt="ONG Conscience Féminine" class="h-16">
                </a>
                
                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-600 focus:outline-none">
                        <i class="bi bi-list text-3xl"></i>
                    </button>
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="nav-link text-gray-900 px-3 py-2 {{ request()->routeIs('home') ? 'active' : '' }}">
                        Accueil
                    </a>
                    <a href="{{ route('about') }}" class="nav-link text-gray-900 px-3 py-2 {{ request()->routeIs('about') ? 'active' : '' }}">
                        À propos
                    </a>
                    <a href="{{ route('activities') }}" class="nav-link text-gray-900 px-3 py-2 {{ request()->routeIs('activities') || request()->routeIs('activities.show') ? 'active' : '' }}">
                        Activités
                    </a>
                    <a href="{{ route('contact') }}" class="nav-link text-gray-900 px-3 py-2 {{ request()->routeIs('contact') ? 'active' : '' }}">
                        Contact
                    </a>
                    <a href="#" class="btn-primary">Faire un don</a>
                </div>
            </div>
            
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="md:hidden hidden mt-4 pb-4">
                <div class="flex flex-col space-y-3">
                    <a href="{{ route('home') }}" class="nav-link text-gray-900 px-3 py-2 {{ request()->routeIs('home') ? 'active' : '' }}">
                        Accueil
                    </a>
                    <a href="{{ route('about') }}" class="nav-link text-gray-900 px-3 py-2 {{ request()->routeIs('about') ? 'active' : '' }}">
                        À propos
                    </a>
                    <a href="{{ route('activities') }}" class="nav-link text-gray-900 px-3 py-2 {{ request()->routeIs('activities') || request()->routeIs('activities.show') ? 'active' : '' }}">
                        Activités
                    </a>
                    <a href="{{ route('contact') }}" class="nav-link text-gray-900 px-3 py-2 {{ request()->routeIs('contact') ? 'active' : '' }}">
                        Contact
                    </a>
                    <a href="#" class="btn-primary inline-block text-center mt-2">Faire un don</a>
                </div>
            </div>
        </nav>
    </header>
    
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-4 container mx-auto mt-4" id="success-message">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="bi bi-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">
                        {{ session('success') }}
                    </p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button" class="inline-flex bg-green-50 rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none" onclick="document.getElementById('success-message').remove()">
                            <span class="sr-only">Fermer</span>
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-400 p-4 container mx-auto mt-4" id="error-message">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="bi bi-x-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">
                        {{ session('error') }}
                    </p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button" class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none" onclick="document.getElementById('error-message').remove()">
                            <span class="sr-only">Fermer</span>
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- About -->
                <div>
                    <h3 class="text-xl font-bold mb-4">ONG Conscience Féminine</h3>
                    <p class="text-gray-300 mb-4">
                        Nous promouvons le développement intellectuel et l'épanouissement des jeunes filles, futures leaders de demain.
                    </p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-white hover:text-primary transition-colors">
                            <i class="bi bi-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-white hover:text-primary transition-colors">
                            <i class="bi bi-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-white hover:text-primary transition-colors">
                            <i class="bi bi-twitter-x text-xl"></i>
                        </a>
                        <a href="#" class="text-white hover:text-primary transition-colors">
                            <i class="bi bi-youtube text-xl"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Links -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors">
                                <i class="bi bi-chevron-right text-xs mr-2"></i>Accueil
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="text-gray-300 hover:text-white transition-colors">
                                <i class="bi bi-chevron-right text-xs mr-2"></i>À propos
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('activities') }}" class="text-gray-300 hover:text-white transition-colors">
                                <i class="bi bi-chevron-right text-xs mr-2"></i>Activités
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition-colors">
                                <i class="bi bi-chevron-right text-xs mr-2"></i>Contact
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Contact</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="bi bi-geo-alt text-primary mr-3 mt-1"></i>
                            <span>Cotonou, Bénin</span>
                        </li>
                        <li class="flex items-start">
                            <i class="bi bi-envelope text-primary mr-3 mt-1"></i>
                            <a href="mailto:contact@consciencefeminine.org" class="hover:text-primary transition-colors">
                                contact@consciencefeminine.org
                            </a>
                        </li>
                        <li class="flex items-start">
                            <i class="bi bi-telephone text-primary mr-3 mt-1"></i>
                            <a href="tel:+22901952048" class="hover:text-primary transition-colors">
                                (+229) 01 95 20 48 48
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Newsletter -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Newsletter</h3>
                    <p class="text-gray-300 mb-4">
                        Inscrivez-vous à notre newsletter pour rester informé de nos activités et événements.
                    </p>
                    <form class="mt-4">
                        <div class="flex">
                            <input type="email" class="px-4 py-2 w-full focus:outline-none rounded-l" placeholder="Votre email">
                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-r hover:bg-primary-dark transition-colors">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">
                        &copy; {{ date('Y') }} ONG Conscience Féminine. Tous droits réservés.
                    </p>
                    <div class="mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors mx-3">
                            Mentions légales
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors mx-3">
                            Politique de confidentialité
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Back to top button -->
    <button id="back-to-top" class="fixed bottom-6 right-6 bg-primary text-white p-3 rounded-full shadow-lg opacity-0 invisible transition-all duration-300">
        <i class="bi bi-arrow-up"></i>
    </button>
    
    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
        
        // Back to top button
        const backToTopButton = document.getElementById('back-to-top');
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('opacity-0', 'invisible');
                backToTopButton.classList.add('opacity-100', 'visible');
            } else {
                backToTopButton.classList.remove('opacity-100', 'visible');
                backToTopButton.classList.add('opacity-0', 'invisible');
            }
        });
        
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Auto-close flash messages after 5 seconds
        setTimeout(function() {
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');
            
            if (successMessage) {
                successMessage.remove();
            }
            if (errorMessage) {
                errorMessage.remove();
            }
        }, 5000);
    </script>
    
    @yield('scripts')
</body>
</html>