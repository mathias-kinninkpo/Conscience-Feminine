<!-- resources/views/admin/announcements/edit.blade.php -->
@extends('layouts.admin')

@section('title', 'Modifier une annonce')

@section('page-title', 'Modifier une annonce')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.announcements.index') }}" class="inline-flex items-center text-gray-600 hover:text-primary">
            <i class="bi bi-arrow-left mr-2"></i> Retour à la liste
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Modifier l'annonce</h2>
            
            <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Titre -->
                    <div class="col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre <span class="text-red-600">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $announcement->title) }}" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="Titre de l'annonce">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Date de publication -->
                    <div>
                        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Date de publication</label>
                        <input type="datetime-local" id="published_at" name="published_at" 
                               value="{{ old('published_at', $announcement->published_at ? \Carbon\Carbon::parse($announcement->published_at)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        @error('published_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Image -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        <input type="file" id="image" name="image" accept="image/*"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <p class="mt-1 text-sm text-gray-500">Formats acceptés : JPEG, PNG, JPG, GIF. Taille max : 2MB</p>
                        
                        @if($announcement->image)
                            <div class="mt-3">
                                <p class="text-sm font-medium text-gray-700 mb-1">Image actuelle :</p>
                                <div class="flex items-center">
                                    <img src="{{ asset('storage/' . $announcement->image) }}" alt="{{ $announcement->title }}" class="h-32 w-auto rounded-md object-cover">
                                    <button type="button" onclick="document.getElementById('remove_image').checked = true; this.parentNode.parentNode.style.display = 'none';" 
                                            class="ml-2 p-1 bg-red-100 text-red-600 rounded-full hover:bg-red-200">
                                        <i class="bi bi-trash"></i>
                                    </button>
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
                    
                    <!-- Description -->
                    <div class="col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-red-600">*</span></label>
                        <textarea id="description" name="description" rows="6" required
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                  placeholder="Description détaillée de l'annonce">{{ old('description', $announcement->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.announcements.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md mr-2 hover:bg-gray-400 transition-colors duration-300">
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
        // Si nécessaire, ajoutez ici du JavaScript pour la gestion de l'éditeur de texte enrichi
        // ou pour la prévisualisation de l'image avant l'upload
        document.getElementById('image').onchange = function(e) {
            if (e.target.files.length === 0) return;
            
            const preview = document.createElement('div');
            preview.className = 'mt-3';
            
            const img = document.createElement('img');
            img.src = URL.createObjectURL(e.target.files[0]);
            img.className = 'h-32 w-auto rounded-md object-cover';
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
        };
    </script>
    @endpush
@endsection