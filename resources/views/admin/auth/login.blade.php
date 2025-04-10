<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('storage/images/logo.png') }}" />
    <title>Connexion - ONG Conscience Féminine</title>
    
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
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
        <!-- Background decoration -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            <div class="absolute top-0 right-0 w-80 h-80 bg-primary opacity-10 rounded-full transform translate-x-20 -translate-y-20"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-tertiary opacity-10 rounded-full transform -translate-x-20 translate-y-20"></div>
            <div class="absolute top-1/3 left-1/4 w-60 h-60 bg-secondary opacity-10 rounded-full transform -translate-x-1/2 -translate-y-1/2"></div>
        </div>
        
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-xl z-10">
            <div>
                <div class="flex justify-center">
                    <img class="h-20 w-auto" src="{{ asset('storage/images/logo.png') }}" alt="Logo ONG Conscience Féminine">
                </div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Administration
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Connectez-vous pour accéder au tableau de bord
                </p>
            </div>
            
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4" id="error-message">
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
            
            <form class="mt-8 space-y-6" action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                
                <div class="rounded-md -space-y-px">
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email</label>
                        <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm" placeholder="Votre adresse email" value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm" placeholder="Votre mot de passe">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-900">
                            Se souvenir de moi
                        </label>
                    </div>
                    
                    <div class="text-sm">
                        <a href="{{ route('admin.password.request') }}" class="font-medium text-primary hover:text-primary-dark">
                            Mot de passe oublié?
                        </a>
                    </div>
                </div>
                
                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="bi bi-shield-lock"></i>
                        </span>
                        Se connecter
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-sm font-medium text-primary hover:text-primary-dark">
                    <i class="bi bi-arrow-left mr-1"></i> Retour au site
                </a>
            </div>
        </div>
    </div>
</body>
</html>