<!-- resources/views/admin/faqs/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Gestion des FAQ')

@section('page-title', 'Gestion des FAQ')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Liste des FAQ</h2>
            <p class="text-sm text-gray-600 mt-1">Gérez les questions fréquemment posées</p>
        </div>
        <a href="{{ route('admin.faqs.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition-colors duration-300 flex items-center">
            <i class="bi bi-plus-lg mr-2"></i> Ajouter une FAQ
        </a>
    </div>

    @if($faqs->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <img src="{{ asset('storage/images/empty.svg') }}" alt="Aucune FAQ" class="w-32 h-32 mx-auto mb-4 opacity-50">
            <h3 class="text-lg font-medium text-gray-900 mb-1">Aucune FAQ disponible</h3>
            <p class="text-gray-500 mb-6">Commencez par créer votre première question fréquemment posée</p>
            <a href="{{ route('admin.faqs.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors duration-300">
                <i class="bi bi-plus-lg mr-2"></i> Créer une FAQ
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
                <ul id="sortable-faqs" class="divide-y divide-gray-200">
                    @foreach($faqs as $faq)
                        <li class="faq-item p-6 hover:bg-gray-50 transition-colors duration-150" data-id="{{ $faq->id }}">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 cursor-move mr-4 text-gray-400 mt-1">
                                    <i class="bi bi-grip-vertical text-lg"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $faq->question }}</h3>
                                        <div class="flex items-center space-x-2 ml-4">
                                            <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="text-blue-600 hover:text-blue-900 p-1" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="#" onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer cette FAQ ?')){ document.getElementById('delete-form-{{ $faq->id }}').submit(); }" class="text-red-600 hover:text-red-900 p-1" title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                            <form id="delete-form-{{ $faq->id }}" action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                    <div class="mt-1 text-sm text-gray-600 line-clamp-3">
                                        {!! nl2br(e(Str::limit($faq->answer, 200))) !!}
                                        @if(strlen($faq->answer) > 200)
                                            <button type="button" class="text-primary hover:text-primary-dark ml-1 font-medium show-more" data-full-text="{{ nl2br(e($faq->answer)) }}">
                                                Voir plus
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="px-6 py-4 bg-gray-50">
                {{ $faqs->links() }}
            </div>
        </div>
    @endif

    <!-- Modal pour afficher la réponse complète -->
    <div id="answer-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl max-w-lg w-full">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Réponse complète</h3>
                <button type="button" onclick="closeAnswerModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="p-6 max-h-96 overflow-y-auto">
                <div id="modal-content" class="text-gray-700"></div>
            </div>
            <div class="bg-gray-50 px-6 py-3 flex justify-end">
                <button type="button" onclick="closeAnswerModal()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors duration-300">
                    Fermer
                </button>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .sortable-ghost {
            background-color: #e5e7eb;
            opacity: 0.5;
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
            const sortableList = document.getElementById('sortable-faqs');
            const saveOrderBtn = document.getElementById('save-order');
            const answerModal = document.getElementById('answer-modal');
            const modalContent = document.getElementById('modal-content');
            
            // Configuration du tri par glisser-déposer
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
                    const items = sortableList.querySelectorAll('.faq-item');
                    const order = Array.from(items).map(item => item.dataset.id);
                    
                    fetch('{{ route('admin.faqs.reorder') }}', {
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
                            notification.innerHTML = '<i class="bi bi-check-circle mr-2"></i> Ordre des FAQ mis à jour avec succès';
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
            
            // Configuration des boutons "Voir plus"
            const showMoreButtons = document.querySelectorAll('.show-more');
            showMoreButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const fullText = this.dataset.fullText;
                    modalContent.innerHTML = fullText;
                    answerModal.classList.remove('hidden');
                });
            });
            
            // Fonction pour fermer la modal
            window.closeAnswerModal = function() {
                answerModal.classList.add('hidden');
            };
            
            // Fermer la modal si on clique en dehors
            answerModal.addEventListener('click', function(e) {
                if (e.target === answerModal) {
                    closeAnswerModal();
                }
            });
        });
    </script>
    @endpush
@endsection