<!-- resources/views/admin/settings/appearance.blade.php -->
@extends('layouts.admin')

@section('title', 'Paramètres d\'apparence')

@section('page-title', 'Paramètres d\'apparence')

@section('content')
    <div class="mb-6">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.settings') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors duration-300">
                Général
            </a>
            <a href="{{ route('admin.settings.appearance') }}" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors duration-300">
                Apparence
            </a>
            <a href="{{ route('admin.settings.email') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors duration-300">
                Email
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-800">Paramètres d'apparence</h2>
        </div>
        
        <form action="{{ route('admin.settings.appearance.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="p-6">
                <!-- Couleurs du thème -->
                <h3 class="text-md font-medium text-gray-700 mb-4">Couleurs du thème</h3>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3 mb-8">
                    <!-- Couleur primaire -->
                    <div>
                        <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-1">Couleur primaire</label>
                        <div class="flex items-center">
                            <input type="color" id="primary_color" name="primary_color" value="{{ old('primary_color', setting('primary_color', '#008B48')) }}"
                                   class="h-10 w-10 rounded border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            <input type="text" id="primary_color_text" 
                                   value="{{ old('primary_color', setting('primary_color', '#008B48')) }}"
                                   class="ml-2 flex-1 rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                   placeholder="#000000" readonly>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Couleur principale du site (boutons, liens, titres, etc.)</p>
                        @error('primary_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Couleur secondaire -->
                    <div>
                        <label for="secondary_color" class="block text-sm font-medium text-gray-700 mb-1">Couleur secondaire</label>
                        <div class="flex items-center">
                            <input type="color" id="secondary_color" name="secondary_color" value="{{ old('secondary_color', setting('secondary_color', '#97BF0D')) }}"
                                   class="h-10 w-10 rounded border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            <input type="text" id="secondary_color_text" 
                                   value="{{ old('secondary_color', setting('secondary_color', '#97BF0D')) }}"
                                   class="ml-2 flex-1 rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                   placeholder="#000000" readonly>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Couleur secondaire du site (accents, badges, etc.)</p>
                        @error('secondary_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Couleur tertiaire -->
                    <div>
                        <label for="tertiary_color" class="block text-sm font-medium text-gray-700 mb-1">Couleur tertiaire</label>
                        <div class="flex items-center">
                            <input type="color" id="tertiary_color" name="tertiary_color" value="{{ old('tertiary_color', setting('tertiary_color', '#920E7C')) }}"
                                   class="h-10 w-10 rounded border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            <input type="text" id="tertiary_color_text" 
                                   value="{{ old('tertiary_color', setting('tertiary_color', '#920E7C')) }}"
                                   class="ml-2 flex-1 rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                   placeholder="#000000" readonly>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Couleur tertiaire du site (éléments spéciaux, etc.)</p>
                        @error('tertiary_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Prévisualisation des couleurs -->
                <div class="mb-8 p-4 border border-gray-200 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Prévisualisation des couleurs</h4>
                    <div class="flex flex-wrap gap-4">
                        <div class="preview-box rounded-md overflow-hidden shadow-sm" style="background-color: {{ setting('primary_color', '#008B48') }};">
                            <div class="px-4 py-2 text-white">Primaire</div>
                            <div class="bg-white px-4 py-2 text-gray-800">
                                <div class="mb-1" style="color: {{ setting('primary_color', '#008B48') }};">Texte en couleur primaire</div>
                                <button class="px-3 py-1 rounded-md text-white" style="background-color: {{ setting('primary_color', '#008B48') }};">Bouton</button>
                            </div>
                        </div>
                        
                        <div class="preview-box rounded-md overflow-hidden shadow-sm" style="background-color: {{ setting('secondary_color', '#97BF0D') }};">
                            <div class="px-4 py-2 text-white">Secondaire</div>
                            <div class="bg-white px-4 py-2 text-gray-800">
                                <div class="mb-1" style="color: {{ setting('secondary_color', '#97BF0D') }};">Texte en couleur secondaire</div>
                                <button class="px-3 py-1 rounded-md text-white" style="background-color: {{ setting('secondary_color', '#97BF0D') }};">Bouton</button>
                            </div>
                        </div>
                        
                        <div class="preview-box rounded-md overflow-hidden shadow-sm" style="background-color: {{ setting('tertiary_color', '#920E7C') }};">
                            <div class="px-4 py-2 text-white">Tertiaire</div>
                            <div class="bg-white px-4 py-2 text-gray-800">
                                <div class="mb-1" style="color: {{ setting('tertiary_color', '#920E7C') }};">Texte en couleur tertiaire</div>
                                <button class="px-3 py-1 rounded-md text-white" style="background-color: {{ setting('tertiary_color', '#920E7C') }};">Bouton</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Image d'arrière-plan -->
                <h3 class="text-md font-medium text-gray-700 mb-4">Image d'arrière-plan</h3>
                <div class="mb-8">
                    <div>
                        <label for="background_image" class="block text-sm font-medium text-gray-700 mb-1">Image d'arrière-plan (optionnelle)</label>
                        <input type="file" id="background_image" name="background_image" accept="image/*"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <p class="mt-1 text-sm text-gray-500">Formats acceptés : JPEG, PNG, JPG, GIF. Taille max : 2MB.</p>
                        
                        @if(setting('background_image'))
                            <div class="mt-3">
                                <p class="text-sm font-medium text-gray-700 mb-1">Image actuelle :</p>
                                <div class="relative inline-block">
                                    <img src="{{ asset('storage/' . setting('background_image')) }}" alt="Image d'arrière-plan" class="h-32 rounded-md">
                                    <button type="button" onclick="document.getElementById('remove_background_image').checked = true; this.closest('.relative').classList.add('hidden');" 
                                            class="absolute top-2 right-2 p-1 bg-red-100 text-red-600 rounded-full hover:bg-red-200">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-2 hidden">
                                <input type="checkbox" id="remove_background_image" name="remove_background_image">
                                <label for="remove_background_image">Supprimer l'image d'arrière-plan</label>
                            </div>
                        @endif
                        
                        @error('background_image')
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

    @push('styles')
    <style>
        .preview-box {
            width: 200px;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Synchroniser le sélecteur de couleur avec le champ texte
        document.getElementById('primary_color').addEventListener('input', function() {
            document.getElementById('primary_color_text').value = this.value;
            updatePreview();
        });
        
        document.getElementById('secondary_color').addEventListener('input', function() {
            document.getElementById('secondary_color_text').value = this.value;
            updatePreview();
        });
        
        document.getElementById('tertiary_color').addEventListener('input', function() {
            document.getElementById('tertiary_color_text').value = this.value;
            updatePreview();
        });
        
        // Fonction pour mettre à jour la prévisualisation
        function updatePreview() {
            const primaryColor = document.getElementById('primary_color').value;
            const secondaryColor = document.getElementById('secondary_color').value;
            const tertiaryColor = document.getElementById('tertiary_color').value;
            
            // Mettre à jour les prévisualisations
            const previewBoxes = document.querySelectorAll('.preview-box');
            
            // Primaire
            previewBoxes[0].style.backgroundColor = primaryColor;
            previewBoxes[0].querySelector('div.bg-white div:first-child').style.color = primaryColor;
            previewBoxes[0].querySelector('button').style.backgroundColor = primaryColor;
            
            // Secondaire
            previewBoxes[1].style.backgroundColor = secondaryColor;
            previewBoxes[1].querySelector('div.bg-white div:first-child').style.color = secondaryColor;
            previewBoxes[1].querySelector('button').style.backgroundColor = secondaryColor;
           
            // Tertiaire
            previewBoxes[2].style.backgroundColor = tertiaryColor;
            previewBoxes[2].querySelector('div.bg-white div:first-child').style.color = tertiaryColor;
            previewBoxes[2].querySelector('button').style.backgroundColor = tertiaryColor;
        }
    </script>
    @endpush
@endsection