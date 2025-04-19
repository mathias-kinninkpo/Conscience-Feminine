<!-- resources/views/admin/users/change-password.blade.php -->
@extends('layouts.admin')

@section('title', 'Changer mon mot de passe')

@section('page-title', 'Changer mon mot de passe')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Modification de votre mot de passe</h2>
                
                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="bi bi-check-circle text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <form action="{{ route('admin.profile.update-password') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-4">
                        <!-- Mot de passe actuel -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe actuel <span class="text-red-600">*</span></label>
                            <input type="password" id="current_password" name="current_password" required
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                   placeholder="Votre mot de passe actuel">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Nouveau mot de passe -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe <span class="text-red-600">*</span></label>
                            <input type="password" id="password" name="password" required
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                   placeholder="Minimum 8 caractères">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Confirmation du nouveau mot de passe -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le nouveau mot de passe <span class="text-red-600">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                   placeholder="Confirmer votre nouveau mot de passe">
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <p class="text-sm text-gray-600 mb-4">
                            <i class="bi bi-info-circle mr-1"></i> Votre nouveau mot de passe doit contenir au moins 8 caractères.
                        </p>
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors duration-300">
                            <i class="bi bi-shield-lock mr-2"></i> Mettre à jour le mot de passe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection