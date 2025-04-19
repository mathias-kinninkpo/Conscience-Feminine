<!-- resources/views/admin/sliders/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Gestion des sliders')

@section('page-title', 'Gestion des sliders')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Liste des sliders</h2>
            <p class="text-sm text-gray-600 mt-1">Gérez les sliders affichés sur la page d'accueil</p>
        </div>
        <a href="{{ route('admin.sliders.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition-colors duration-300 flex items-center">
            <i class="bi bi-plus-lg mr-2"></i> Ajouter un slider
        </a>
    </div>

    @if($sliders->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <img src="{{ asset('storage/images/empty.svg') }}" alt="Aucun slider" class="w-32 h-32 mx-auto mb-4 opacity-50">
            <h3 class="text-lg font-medium text-gray-900 mb-1">Aucun slider disponible</h3>
            <p class="text-gray-500 mb-6">Commencez par créer votre premier slider pour la page d'accueil</p>
            <a href="{{ route('admin.sliders.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors duration-300">
                <i class="bi bi-plus-lg mr-2"></i> Créer un slider
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    <i class="bi bi-info-circle mr-1"></i> Glissez-déposez les éléments pour réorganiser leur ordre d'affichage
                </div>
                <button type="button" id="save-order" class="text-sm bg-primary text-white px-3 py-1 rounded hover:bg-primary-dark transition-colors duration-200 flex items-center hidden">
                    <i class="bi bi-save mr-1"></i> Enregistrer l'ordre
                </button>
            </div>
            
            <div class="overflow-hidden">
                <ul id="sortable-sliders" class="divide-y divide-gray-200">
                    @foreach($sliders as $slider)
                        <li class="slider-item flex items-center p-6 hover:bg-gray-50 transition-colors duration-150" data-id="{{ $slider->id }}">
                            <div class="flex-shrink-0 cursor-move mr-4 text-gray-400">
                                <i class="bi bi-grip-vertical text-lg"></i>
                            </div>
                            <div class="flex-shrink-0 h-24 w-40 mr-4 bg-gray-100 rounded overflow-hidden">
                                @if($slider->image)
                                    <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center">
                                        <i class="bi bi-image text-gray-400 text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $slider->title }}</h3>
                                @if($slider->subtitle)
                                    <p class="text-sm text-gray-500 mb-2">{{ Str::limit($slider->subtitle, 100) }}</p>
                                @endif
                                @if($slider->button_text && $slider->button_url)
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="bi bi-link-45deg mr-1"></i> {{ $slider->button_text }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex items-center space-x-2 ml-4">
                                <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="text-blue-600 hover:text-blue-900 p-1" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="#" onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer ce slider ?')){ document.getElementById('delete-form-{{ $slider->id }}').submit(); }" class="text-red-600 hover:text-red-900 p-1" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </a>
                                <form id="delete-form-{{ $slider->id }}" action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="px-6 py-4 bg-gray-50">
                {{ $sliders->links() }}
            </div>
        </div>
    @endif

    @push('styles')
    <style>
        .sortable-ghost {
            background-color: #e5e7eb;
            opacity: 0.5;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortableList = document.getElementById('sortable-sliders');
            const saveOrderBtn = document.getElementById('save-order');
            
            if (sortableList) {
                let hasChanged = false;
                
                const sortable = new Sortable(sortableList, {
                    handle: '.cursor-move',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    onEnd: function() {
                        hasChanged = true;
                        saveOrderBtn.classList.remove('hidden');
                    }
                });
                
                saveOrderBtn.addEventListener('click', function() {
                    const items = sortableList.querySelectorAll('.slider-item');
                    const order = Array.from(items).map(item => item.dataset.id);
                    
                    fetch('{{ route('admin.sliders.reorder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ order: order })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            saveOrderBtn.classList.add('hidden');
                            hasChanged = false;
                            
                            // Afficher une notification de succès
                            const notification = document.createElement('div');
                            notification.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg';
                            notification.innerHTML = '<i class="bi bi-check-circle mr-2"></i> Ordre des sliders mis à jour avec succès';
                            document.body.appendChild(notification);
                            
                            setTimeout(() => {
                                notification.remove();
                            }, 3000);
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        
                        // Afficher une notification d'erreur
                        const notification = document.createElement('div');
                        notification.className = 'fixed bottom-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg';
                        notification.innerHTML = '<i class="bi bi-exclamation-circle mr-2"></i> Erreur lors de la mise à jour de l\'ordre';
                        document.body.appendChild(notification);
                        
                        setTimeout(() => {
                            notification.remove();
                        }, 3000);
                    });
                });
                
                // Avertir l'utilisateur s'il quitte la page sans enregistrer
                window.addEventListener('beforeunload', function(e) {
                    if (hasChanged) {
                        e.preventDefault();
                        e.returnValue = 'Vous avez des modifications non enregistrées. Êtes-vous sûr de vouloir quitter cette page ?';
                    }
                });
            }
        });
    </script>
    @endpush
@endsection