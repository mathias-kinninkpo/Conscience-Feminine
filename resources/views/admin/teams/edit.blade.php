<!-- resources/views/admin/team/edit.blade.php -->
@extends('layouts.admin')

@section('title', 'Modifier un membre')

@section('page-title', 'Modifier un membre')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.team.index') }}" class="inline-flex items-center text-gray-600 hover:text-primary">
            <i class="bi bi-arrow-left mr-2"></i> Retour à la liste
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Modifier le membre</h2>
            
            <form action="{{ route('admin.team.update', $teamMember->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Nom -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-600">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $teamMember->name) }}" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="Nom complet">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Rôle -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Rôle/Fonction <span class="text-red-600">*</span></label>
                        <input type="text" id="role" name="role" value="{{ old('role', $teamMember->role) }}" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="Ex: Directeur, Coordinateur, etc.">
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Image -->
                    <div class="col-span-2">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
                        <input type="file" id="image" name="image" accept="image/*"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <p class="mt-1 text-sm text-gray-500">Formats acceptés : JPEG, PNG, JPG, GIF. Taille max : 2MB. Dimensions recommandées : 400x400px (carrée).</p>
                        
                        @if($teamMember->image)
                            <div class="mt-3">
                                <p class="text-sm font-medium text-gray-700 mb-1">Photo actuelle :</p>
                                <div class="relative inline-block">
                                    <img src="{{ asset('storage/' . $teamMember->image) }}" alt="{{ $teamMember->name }}" class="h-48 w-48 rounded-full object-cover border border-gray-200">
                                    <div class="absolute top-0 right-0">
                                        <button type="button" onclick="document.getElementById('remove_image').checked = true; this.closest('.relative').classList.add('opacity-50'); this.classList.add('hidden');" 
                                                class="p-1 bg-red-100 text-red-600 rounded-full hover:bg-red-200">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 hidden">
                                <input type="checkbox" id="remove_image" name="remove_image">
                                <label for="remove_image">Supprimer la photo actuelle</label>
                            </div>
                        @endif
                        
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Biographie -->
                    <div class="col-span-2">
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Biographie</label>
                        <textarea id="bio" name="bio" rows="6"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                  placeholder="Courte biographie ou description du membre">{{ old('bio', $teamMember->bio) }}</textarea>
                        @error('bio')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.team.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md mr-2 hover:bg-gray-400 transition-colors duration-300">
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
            img.className = 'h-48 w-48 rounded-full object-cover border border-gray-200';
            img.onload = function() {
                URL.revokeObjectURL(this.src);
            };
            
            const previewLabel = document.createElement('p');
            previewLabel.textContent = 'Nouvelle photo (aperçu) :';
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
    </script>
    @endpush
@endsection