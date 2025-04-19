<!-- resources/views/admin/settings/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Paramètres du site')

@section('page-title', 'Paramètres du site')

@section('content')
    <div class="mb-6">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.settings') }}" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors duration-300">
                Général
            </a>
            <a href="{{ route('admin.settings.appearance') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors duration-300">
                Apparence
            </a>
            <a href="{{ route('admin.settings.email') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors duration-300">
                Email
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-800">Paramètres généraux du site</h2>
        </div>
        
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="p-6">
                <!-- Informations du site -->
                <h3 class="text-md font-medium text-gray-700 mb-4">Informations du site</h3>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-8">
                    <!-- Nom du site -->
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700 mb-1">Nom du site <span class="text-red-600">*</span></label>
                        <input type="text" id="site_name" name="site_name" value="{{ old('site_name', setting('site_name')) }}" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="Nom de votre site">
                        @error('site_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Description du site -->
                    <div>
                        <label for="site_description" class="block text-sm font-medium text-gray-700 mb-1">Description du site</label>
                        <textarea id="site_description" name="site_description" rows="3"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="Courte description de votre site">{{ old('site_description', setting('site_description')) }}</textarea>
                        @error('site_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Logo du site -->
                    <div>
                        <label for="site_logo" class="block text-sm font-medium text-gray-700 mb-1">Logo du site</label>
                        <input type="file" id="site_logo" name="site_logo" accept="image/*"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <p class="mt-1 text-sm text-gray-500">Formats acceptés : JPEG, PNG, JPG, GIF, SVG. Taille max : 2MB.</p>
                        
                        @if(setting('site_logo'))
                            <div class="mt-2">
                                <div class="flex items-center">
                                    <img src="{{ asset('storage/' . setting('site_logo')) }}" alt="Logo du site" class="h-12 w-auto">
                                    <button type="button" onclick="document.getElementById('remove_logo').checked = true; this.parentNode.parentNode.classList.add('hidden');" 
                                            class="ml-2 p-1 bg-red-100 text-red-600 rounded-full hover:bg-red-200">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-2 hidden">
                                <input type="checkbox" id="remove_logo" name="remove_logo">
                                <label for="remove_logo">Supprimer le logo actuel</label>
                            </div>
                        @endif
                        
                        @error('site_logo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Favicon du site -->
                    <div>
                        <label for="site_favicon" class="block text-sm font-medium text-gray-700 mb-1">Favicon du site</label>
                        <input type="file" id="site_favicon" name="site_favicon" accept="image/*"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <p class="mt-1 text-sm text-gray-500">Formats acceptés : JPEG, PNG, JPG, GIF, SVG, ICO. Taille max : 1MB.</p>
                        
                        @if(setting('site_favicon'))
                            <div class="mt-2">
                                <div class="flex items-center">
                                    <img src="{{ asset('storage/' . setting('site_favicon')) }}" alt="Favicon du site" class="h-8 w-auto">
                                    <button type="button" onclick="document.getElementById('remove_favicon').checked = true; this.parentNode.parentNode.classList.add('hidden');" 
                                            class="ml-2 p-1 bg-red-100 text-red-600 rounded-full hover:bg-red-200">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-2 hidden">
                                <input type="checkbox" id="remove_favicon" name="remove_favicon">
                                <label for="remove_favicon">Supprimer le favicon actuel</label>
                            </div>
                        @endif
                        
                        @error('site_favicon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Informations de contact -->
                <h3 class="text-md font-medium text-gray-700 mb-4">Informations de contact</h3>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-8">
                    <!-- Email de contact -->
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Email de contact <span class="text-red-600">*</span></label>
                        <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', setting('contact_email')) }}" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="email@exemple.com">
                        @error('contact_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Téléphone de contact -->
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone de contact</label>
                        <input type="text" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', setting('contact_phone')) }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="+229 00 00 00 00">
                        @error('contact_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Adresse de contact -->
                    <div class="md:col-span-2">
                        <label for="contact_address" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                        <textarea id="contact_address" name="contact_address" rows="3"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="Adresse physique">{{ old('contact_address', setting('contact_address')) }}</textarea>
                        @error('contact_address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Réseaux sociaux -->
                <h3 class="text-md font-medium text-gray-700 mb-4">Réseaux sociaux</h3>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Facebook -->
                    <div>
                        <label for="social_facebook" class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                        <div class="flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                <i class="bi bi-facebook"></i>
                            </span>
                            <input type="text" id="social_facebook" name="social_facebook" value="{{ old('social_facebook', setting('social_facebook')) }}"
                                   class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                   placeholder="https://facebook.com/votre-page">
                        </div>
                        @error('social_facebook')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Twitter -->
                    <div>
                        <label for="social_twitter" class="block text-sm font-medium text-gray-700 mb-1">Twitter</label>
                        <div class="flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                <i class="bi bi-twitter"></i>
                            </span>
                            <input type="text" id="social_twitter" name="social_twitter" value="{{ old('social_twitter', setting('social_twitter')) }}"
                                   class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                   placeholder="https://twitter.com/votre-compte">
                        </div>
                        @error('social_twitter')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Instagram -->
                    <div>
                        <label for="social_instagram" class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                        <div class="flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                <i class="bi bi-instagram"></i>
                            </span>
                            <input type="text" id="social_instagram" name="social_instagram" value="{{ old('social_instagram', setting('social_instagram')) }}"
                                   class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                   placeholder="https://instagram.com/votre-compte">
                        </div>
                        @error('social_instagram')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- LinkedIn -->
                    <div>
                        <label for="social_linkedin" class="block text-sm font-medium text-gray-700 mb-1">LinkedIn</label>
                        <div class="flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                <i class="bi bi-linkedin"></i>
                            </span>
                            <input type="text" id="social_linkedin" name="social_linkedin" value="{{ old('social_linkedin', setting('social_linkedin')) }}"
                                   class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                   placeholder="https://linkedin.com/in/votre-profil">
                        </div>
                        @error('social_linkedin')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- YouTube -->
                    <div>
                        <label for="social_youtube" class="block text-sm font-medium text-gray-700 mb-1">YouTube</label>
                        <div class="flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                <i class="bi bi-youtube"></i>
                            </span>
                            <input type="text" id="social_youtube" name="social_youtube" value="{{ old('social_youtube', setting('social_youtube')) }}"
                                   class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                   placeholder="https://youtube.com/c/votre-chaine">
                        </div>
                        @error('social_youtube')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- TikTok -->
                    <div>
                        <label for="social_tiktok" class="block text-sm font-medium text-gray-700 mb-1">TikTok</label>
                        <div class="flex rounded-md shadow-sm">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                <i class="bi bi-tiktok"></i>
                            </span>
                            <input type="text" id="social_tiktok" name="social_tiktok" value="{{ old('social_tiktok', setting('social_tiktok')) }}"
                                   class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                   placeholder="https://tiktok.com/@votre-compte">
                        </div>
                        @error('social_tiktok')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors duration-300">
                    <i class="bi bi-save mr-2"></i> Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
@endsection