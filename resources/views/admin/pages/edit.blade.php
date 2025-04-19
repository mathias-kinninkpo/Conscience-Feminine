<!-- resources/views/admin/pages/edit.blade.php -->
@extends('layouts.admin')

@section('title', 'Modifier une page')

@section('page-title', 'Modifier une page')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.pages.index') }}" class="inline-flex items-center text-gray-600 hover:text-primary">
            <i class="bi bi-arrow-left mr-2"></i> Retour à la liste
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Modifier la page</h2>
            
            <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Titre -->
                    <div class="col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titre <span class="text-red-600">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $page->title) }}" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="Titre de la page">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Slug -->
                    <div class="col-span-2">
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                {{ url('/page/') }}/
                            </span>
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $page->slug) }}"
                                   class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                   placeholder="mon-slug-personnalise">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Laissez vide pour générer automatiquement à partir du titre. Utilisez uniquement des lettres minuscules, des chiffres et des tirets.</p>
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Image -->
                    <div class="col-span-2">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image d'en-tête</label>
                        <input type="file" id="image" name="image" accept="image/*"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <p class="mt-1 text-sm text-gray-500">Formats acceptés : JPEG, PNG, JPG, GIF. Taille max : 2MB</p>
                        
                        @if($page->image)
                            <div class="mt-3">
                                <p class="text-sm font-medium text-gray-700 mb-1">Image actuelle :</p>
                                <div class="flex items-center">
                                    <img src="{{ asset('storage/' . $page->image) }}" alt="{{ $page->title }}" class="h-32 w-auto rounded-md object-cover">
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
                    
                    <!-- Contenu -->
                    <div class="col-span-2">
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Contenu <span class="text-red-600">*</span></label>
                        <textarea id="content" name="content" rows="15" required
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                  placeholder="Contenu de la page">{{ old('content', $page->content) }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.pages.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md mr-2 hover:bg-gray-400 transition-colors duration-300">
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