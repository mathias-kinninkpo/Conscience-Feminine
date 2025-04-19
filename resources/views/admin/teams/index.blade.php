<!-- resources/views/admin/team/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Gestion de l\'équipe')

@section('page-title', 'Gestion de l\'équipe')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Liste des membres de l'équipe</h2>
            <p class="text-sm text-gray-600 mt-1">Gérez les membres de l'équipe affichés sur le site</p>
        </div>
        <a href="{{ route('admin.team.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition-colors duration-300 flex items-center">
            <i class="bi bi-person-plus-fill mr-2"></i> Ajouter un membre
        </a>
    </div>

    @if($teamMembers->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <img src="{{ asset('storage/images/empty.svg') }}" alt="Aucun membre" class="w-32 h-32 mx-auto mb-4 opacity-50">
            <h3 class="text-lg font-medium text-gray-900 mb-1">Aucun membre d'équipe disponible</h3>
            <p class="text-gray-500 mb-6">Commencez par ajouter votre premier membre d'équipe</p>
            <a href="{{ route('admin.team.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors duration-300">
                <i class="bi bi-person-plus-fill mr-2"></i> Ajouter un membre
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    <i class="bi bi-info-circle mr-1"></i> Glissez-déposez les membres pour réorganiser leur ordre d'affichage
                </div>
                <button type="button" id="save-order" class="text-sm bg-primary text-white px-3 py-1 rounded hover:bg-primary-dark transition-colors duration-200 flex items-center hidden">
                    <i class="bi bi-save mr-1"></i> Enregistrer l'ordre
                </button>
            </div>
            
            <div class="overflow-hidden">
                <ul id="sortable-members" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                    @foreach($teamMembers as $member)
                        <li class="member-item bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-150" data-id="{{ $member->id }}">
                            <div class="p-2 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="cursor-move text-gray-400 mr-2">
                                        <i class="bi bi-grip-vertical"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">ID: {{ $member->id }}</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <a href="{{ route('admin.team.edit', $member->id) }}" class="text-blue-600 hover:text-blue-900 p-1" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="#" onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer ce membre ?')){ document.getElementById('delete-form-{{ $member->id }}').submit(); }" class="text-red-600 hover:text-red-900 p-1" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <form id="delete-form-{{ $member->id }}" action="{{ route('admin.team.destroy', $member->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                            <div class="relative h-48 bg-gray-100">
                                @if($member->image)
                                    <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full">
                                        <i class="bi bi-person-circle text-gray-400 text-6xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $member->name }}</h3>
                                <p class="text-sm text-primary font-medium">{{ $member->role }}</p>
                                @if($member->bio)
                                    <p class="mt-2 text-sm text-gray-600 line-clamp-3">{{ Str::limit($member->bio, 100) }}</p>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="px-6 py-4 bg-gray-50">
                {{ $teamMembers->links() }}
            </div>
        </div>
    @endif

    @push('styles')
    <style>
        .sortable-ghost {
            opacity: 0.5;
            background-color: #f3f4f6;
        }
        
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortableList = document.getElementById('sortable-members');
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
                    const items = sortableList.querySelectorAll('.member-item');
                    const order = Array.from(items).map(item => item.dataset.id);
                    
                    fetch('{{ route('admin.team.reorder') }}', {
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
                            notification.innerHTML = '<i class="bi bi-check-circle mr-2"></i> Ordre des membres mis à jour avec succès';
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