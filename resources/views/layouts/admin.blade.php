<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('storage/images/logo.png') }}" />
    <title>ONG Conscience Féminine - Administration | @yield('title', 'Dashboard')</title>
    
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
            background-color: #F9FAFB;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
        
        .sidebar {
            background-color: white;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #374151;
            border-radius: 0.375rem;
            margin-bottom: 0.25rem;
            transition: all 0.2s;
        }
        
        .sidebar-link:hover {
            background-color: #F3F4F6;
            color: var(--color-primary);
        }
        
        .sidebar-link.active {
            background-color: var(--color-primary-light);
            color: white;
        }
        
        .btn-primary {
            background-color: var(--color-primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-primary:hover {
            background-color: var(--color-primary-dark);
        }
        
        .btn-secondary {
            background-color: var(--color-secondary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-secondary:hover {
            background-color: var(--color-secondary-dark);
        }
        
        .card {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 1.25rem;
            color: #111827;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #E5E7EB;
        }
    </style>
    
    @yield('styles')
</head>
<body class="antialiased">
    <div class="min-h-screen bg-gray-50 flex">
        <!-- Sidebar mobile -->
        <div id="mobile-sidebar" class="fixed inset-0 z-40 hidden md:hidden">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true" onClick="toggleSidebar()"></div>
            
            <div class="relative flex flex-col w-72 max-w-xs pb-4 bg-white shadow-xl">
                <div class="absolute top-0 right-0 pt-2 pr-2">
                    <button type="button" class="text-gray-500 hover:text-gray-600" onClick="toggleSidebar()">
                        <span class="sr-only">Fermer le menu</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="flex-1 pt-5 pb-4 overflow-y-auto">
                    <!-- Logo -->
                    <div class="flex items-center px-4 mb-8">
                        <img class="h-14 w-auto" src="{{ asset('storage/images/logo.png') }}" alt="Logo Conscience Féminine">
                        <span class="ml-3 text-xl font-bold text-gray-900">Admin</span>
                    </div>
                    
                    <!-- Navigation -->
                    <nav class="px-2 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 mr-3 text-xl"></i>
                            Dashboard
                        </a>
                        
                        <a href="{{ route('admin.announcements.index') }}" class="sidebar-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                            <i class="bi bi-megaphone mr-3 text-xl"></i>
                            Annonces
                        </a>
                        
                        <a href="{{ route('admin.activities.index') }}" class="sidebar-link {{ request()->routeIs('admin.activities.*') ? 'active' : '' }}">
                            <i class="bi bi-calendar-event mr-3 text-xl"></i>
                            Activités
                        </a>
                        
                        <a href="{{ route('admin.pages.index') }}" class="sidebar-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-text mr-3 text-xl"></i>
                            Pages
                        </a>
                        
                        <a href="{{ route('admin.sliders.index') }}" class="sidebar-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                            <i class="bi bi-sliders mr-3 text-xl"></i>
                            Sliders
                        </a>
                        
                        <a href="{{ route('admin.team.index') }}" class="sidebar-link {{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
                            <i class="bi bi-people mr-3 text-xl"></i>
                            Équipe
                        </a>
                        
                        <a href="{{ route('admin.contacts.index') }}" class="sidebar-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                            <i class="bi bi-envelope mr-3 text-xl"></i>
                            Messages
                            @php
                                $unreadCount = \App\Models\Contact::where('is_read', false)->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="inline-flex items-center justify-center ml-auto px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>
                        
                        <a href="{{ route('admin.faqs.index') }}" class="sidebar-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                            <i class="bi bi-question-circle mr-3 text-xl"></i>
                            FAQ
                        </a>
                        
                        <div class="pt-4 mt-4 border-t border-gray-200">
                            <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Administration
                            </h3>
                            
                            <div class="mt-2 space-y-1">
                                <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                    <i class="bi bi-person-badge mr-3 text-xl"></i>
                                    Utilisateurs
                                </a>
                                
                                <a href="{{ route('admin.settings') }}" class="sidebar-link {{ request()->routeIs('admin.settings') || request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                                    <i class="bi bi-gear mr-3 text-xl"></i>
                                    Paramètres
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        
        <!-- Sidebar desktop -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64">
                <div class="flex flex-col h-0 flex-1 sidebar">
                    <div class="flex items-center h-16 px-4 border-b border-gray-200">
                        <img class="h-10 w-auto" src="{{ asset('storage/images/logo.png') }}" alt="Logo Conscience Féminine">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Conscience Féminine</p>
                            <p class="text-xs font-medium text-gray-500">Administration</p>
                        </div>
                    </div>
                    
                    <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                        <nav class="flex-1 px-4 space-y-1">
                            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="bi bi-speedometer2 mr-3 text-xl"></i>
                                Dashboard
                            </a>
                            
                            <a href="{{ route('admin.announcements.index') }}" class="sidebar-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                                <i class="bi bi-megaphone mr-3 text-xl"></i>
                                Annonces
                            </a>
                            
                            <a href="{{ route('admin.activities.index') }}" class="sidebar-link {{ request()->routeIs('admin.activities.*') ? 'active' : '' }}">
                                <i class="bi bi-calendar-event mr-3 text-xl"></i>
                                Activités
                            </a>
                            
                            <a href="{{ route('admin.pages.index') }}" class="sidebar-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                                <i class="bi bi-file-earmark-text mr-3 text-xl"></i>
                                Pages
                            </a>
                            
                            <a href="{{ route('admin.sliders.index') }}" class="sidebar-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                                <i class="bi bi-sliders mr-3 text-xl"></i>
                                Sliders
                            </a>
                            
                            <a href="{{ route('admin.team.index') }}" class="sidebar-link {{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
                                <i class="bi bi-people mr-3 text-xl"></i>
                                Équipe
                            </a>
                            
                            <a href="{{ route('admin.contacts.index') }}" class="sidebar-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                                <i class="bi bi-envelope mr-3 text-xl"></i>
                                Messages
                                @php
                                    $unreadCount = \App\Models\Contact::where('is_read', false)->count();
                                @endphp
                                @if($unreadCount > 0)
                                    <span class="inline-flex items-center justify-center ml-auto px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
                            </a>
                            
                            <a href="{{ route('admin.faqs.index') }}" class="sidebar-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                                <i class="bi bi-question-circle mr-3 text-xl"></i>
                                FAQ
                            </a>
                            
                            <div class="pt-4 mt-4 border-t border-gray-200">
                                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Administration
                                </h3>
                                
                                <div class="mt-2 space-y-1">
                                    <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                        <i class="bi bi-person-badge mr-3 text-xl"></i>
                                        Utilisateurs
                                    </a>
                                    
                                    <a href="{{ route('admin.settings') }}" class="sidebar-link {{ request()->routeIs('admin.settings') || request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                                        <i class="bi bi-gear mr-3 text-xl"></i>
                                        Paramètres
                                    </a>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main content -->
        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <!-- Top navigation -->
            <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
                <button type="button" class="px-4 text-gray-500 focus:outline-none focus:bg-gray-100 focus:text-gray-600 md:hidden" onClick="toggleSidebar()">
                    <span class="sr-only">Ouvrir le menu</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>
                
                <div class="flex-1 px-4 flex justify-between">
                    <div class="flex-1 flex items-center">
                        <h1 class="text-2xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    
                    <div class="ml-4 flex items-center md:ml-6">
                        <!-- Bouton de notifications -->
                        <button type="button" class="p-1 bg-white text-gray-400 rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            <span class="sr-only">Voir les notifications</span>
                            <i class="bi bi-bell text-xl"></i>
                        </button>
                        
                        <!-- Profil dropdown -->
                        <div class="ml-3 relative">
                            <div class="flex items-center">
                                <div>
                                    <button type="button" class="max-w-xs bg-white rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" id="user-menu-button" aria-expanded="false" aria-haspopup="true" onClick="toggleProfileMenu()">
                                        <span class="sr-only">Ouvrir le menu utilisateur</span>
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/images/avatar.png') }}" alt="Avatar">
                                    </button>
                                </div>
                                
                                <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" id="profile-menu" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    <a href="{{ route('admin.profile.change-password') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Profil</a>
                                    <a href="{{ route('admin.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Paramètres</a>
                                    <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Déconnexion</a>
                                </div>
                            </div>
                            
                            <div class="hidden md:block ml-3">
                                <div class="text-base font-medium text-gray-800">
                                    {{ auth()->user()->name ?? 'Administrateur' }}
                                </div>
                                <div class="text-sm font-medium text-gray-500">
                                    {{ auth()->user()->email ?? 'admin@consciencefeminine.org' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mt-4 mx-6" id="success-message">
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
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mt-4 mx-6" id="error-message">
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
            
            <!-- Errors -->
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mt-4 mx-6" id="validation-errors">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="bi bi-exclamation-triangle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Il y a {{ $errors->count() }} erreur(s) dans le formulaire :
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button type="button" class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none" onclick="document.getElementById('validation-errors').remove()">
                                    <span class="sr-only">Fermer</span>
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Main content area -->
            <main class="flex-1 relative overflow-y-auto focus:outline-none p-6">
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200">
                <div class="max-w-7xl mx-auto py-4 px-4 overflow-hidden sm:px-6 lg:px-8">
                    <p class="text-center text-sm text-gray-500">
                        &copy; {{ date('Y') }} ONG Conscience Féminine. Tous droits réservés.
                    </p>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Scripts -->
    <script>
        // Toggle mobile sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            sidebar.classList.toggle('hidden');
        }
        
        // Toggle profile dropdown
        function toggleProfileMenu() {
            const menu = document.getElementById('profile-menu');
            menu.classList.toggle('hidden');
        }
        
        // Close messages automatically after 5 seconds
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