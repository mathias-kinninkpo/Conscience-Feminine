<!-- resources/views/admin/sliders/edit.blade.php -->
@extends('layouts.admin')

@section('title', 'Modifier un slider')

@section('page-title', 'Modifier un slider')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.sliders.index') }}" class="inline-flex items-center text-gray-600 hover:text-primary">
            <i class="bi bi-arrow-left mr-2"></i> Retour à la liste
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Modifier le slider</h2>
            
            <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Titre -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre <span class="text-red-600">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $slider->title) }}" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="Titre du slider">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Sous-titre -->
                    <div>
                        <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-1">Sous-titre</label>
                        <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $slider->subtitle) }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="Sous-titre du slider (optionnel)">
                        @error('subtitle')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Texte du bouton -->
                    <div>
                        <label for="button_text" class="block text-sm font-medium text-gray-700 mb-1">Texte du bouton</label>
                        <input type="text" id="button_text" name="button_text" value="{{ old('button_text', $slider->button_text) }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="Ex: En savoir plus">
                        @error('button_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- URL du bouton -->
                    <div>
                        <label for="button_url" class="block text-sm font-medium text-gray-700 mb-1">URL du bouton</label>
                        <input type="text" id="button_url" name="button_url" value="{{ old('button_url', $slider->button_url) }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="Ex: /contact">
                        @error('button_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Image -->
                    <div class="col-span-2">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        <input type="file" id="image" name="image" accept="image/*"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <p class="mt-1 text-sm text-gray-500">Formats acceptés : JPEG, PNG, JPG, GIF. Taille max : 2MB. Dimensions recommandées : 1920x800px.</p>
                        
                        @if($slider->image)
                            <div class="mt-3">
                                <p class="text-sm font-medium text-gray-700 mb-1">Image actuelle :</p>
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="max-h-48 rounded-md object-contain">
                                    <div class="absolute top-2 right-2">
                                        <button type="button" onclick="document.getElementById('remove_image').checked = true; this.closest('.relative').classList.add('opacity-50'); this.classList.add('hidden');" 
                                                class="p-1 bg-red-100 text-red-600 rounded-full hover:bg-red-200">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 hidden">
                                <input type="checkbox" id="remove_image" name="remove_image">
                                <label for="remove_image">Supprimer l'image actuelle</label>
                            </div>
                        @endif
                        
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.sliders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md mr-2 hover:bg-gray-400 transition-colors duration-300">
                        Annuler
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors duration-300">
                        <i class="bi bi-check-lg mr-2"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Prévisualisation de l'image avant l'upload
        document.getElementById('image').addEventListener('change', function(e) {
            if (e.target.files.length === 0) return;
            
            const preview = document.createElement('div');
            preview.className = 'mt-3';
            
            const img = document.createElement('img');
            img.src = URL.createObjectURL(e.target.files[0]);
            img.className = 'max-h-48 rounded-md object-contain';
            img.onload = function() {
                URL.revokeObjectURL(this.src);
            };
            
            const previewLabel = document.createElement('p');
            previewLabel.textContent = 'Nouvelle image (aperçu) :';
            previewLabel.className = 'text-sm font-medium text-gray-700 mb-1';
            
            // Supprimer l'aperçu précédent s'il existe
            const oldPreview = document.querySelector('.image-preview');
            if (oldPreview) {
                oldPreview.remove();
            }
            
            preview.classList.add('image-preview');
            preview.appendChild(previewLabel);
            preview.appendChild(img);
            
            e.target.parentNode.appendChild(preview);
            
            // Réinitialiser la case à cocher de suppression si elle était cochée
            document.getElementById('remove_image').checked = false;
        });
        
        // Validation du formulaire
        document.querySelector('form').addEventListener('submit', function(e) {
            const buttonText = document.getElementById('button_text').value;
            const buttonUrl = document.getElementById('button_url').value;
            
            // Si un des champs du bouton est rempli, l'autre doit l'être aussi
            if ((buttonText && !buttonUrl) || (!buttonText && buttonUrl)) {
                e.preventDefault();
                alert('Si vous spécifiez un texte de bouton, vous devez également fournir une URL, et vice versa.');
            }
        });
    </script>
    @endpush
@endsection