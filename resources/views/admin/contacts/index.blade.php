<!-- resources/views/admin/contacts/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Gestion des messages')

@section('page-title', 'Gestion des messages')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Liste des messages</h2>
            <p class="text-sm text-gray-600 mt-1">Gérez les messages envoyés via le formulaire de contact</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.contacts.unread') }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition-colors duration-300 flex items-center">
                <i class="bi bi-envelope mr-2"></i> Messages non lus
                @if($unreadCount = \App\Models\Contact::where('is_read', false)->count())
                    <span class="ml-2 bg-white text-yellow-500 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold">{{ $unreadCount }}</span>
                @endif
            </a>
        </div>
    </div>

    @if($contacts->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <img src="{{ asset('storage/images/empty.svg') }}" alt="Aucun message" class="w-32 h-32 mx-auto mb-4 opacity-50">
            <h3 class="text-lg font-medium text-gray-900 mb-1">Aucun message reçu</h3>
            <p class="text-gray-500">Aucun message n'a été envoyé via le formulaire de contact.</p>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <form action="{{ route('admin.contacts.bulk-delete') }}" method="POST" id="bulk-form">
                    @csrf
                    <div class="flex flex-wrap items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="select-all" class="rounded text-primary focus:ring-primary">
                            <label for="select-all" class="text-sm text-gray-700">Tout sélectionner</label>
                        </div>
                        <div class="flex items-center space-x-2 mt-2 sm:mt-0">
                            <button type="button" onclick="confirmBulkAction('mark-read')" class="text-sm bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition-colors duration-200 flex items-center">
                                <i class="bi bi-envelope-open mr-1"></i> Marquer comme lu
                            </button>
                            <button type="button" onclick="confirmBulkAction('delete')" class="text-sm bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition-colors duration-200 flex items-center">
                                <i class="bi bi-trash mr-1"></i> Supprimer
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                                <!-- Checkbox column -->
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expéditeur</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sujet</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($contacts as $contact)
                            <tr class="{{ $contact->is_read ? '' : 'bg-yellow-50' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="selected[]" form="bulk-form" value="{{ $contact->id }}" class="message-checkbox rounded text-primary focus:ring-primary">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                            <span class="text-gray-500 font-medium">{{ strtoupper(substr($contact->name, 0, 1)) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $contact->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $contact->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm {{ $contact->is_read ? 'text-gray-500' : 'font-semibold text-gray-900' }}">
                                        {{ Str::limit($contact->subject, 50) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $contact->created_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($contact->is_read)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="bi bi-envelope-open mr-1"></i> Lu
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            <i class="bi bi-envelope mr-1"></i> Non lu
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.contacts.show', $contact->id) }}" class="text-primary hover:text-primary-dark mr-3" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($contact->is_read)
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('unread-form-{{ $contact->id }}').submit();" class="text-yellow-600 hover:text-yellow-900 mr-3" title="Marquer comme non lu">
                                            <i class="bi bi-envelope"></i>
                                        </a>
                                        <form id="unread-form-{{ $contact->id }}" action="{{ route('admin.contacts.mark-as-unread', $contact->id) }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    @else
                                        <a href="#" onclick="event.preventDefault(); document.getElementById('read-form-{{ $contact->id }}').submit();" class="text-green-600 hover:text-green-900 mr-3" title="Marquer comme lu">
                                            <i class="bi bi-envelope-open"></i>
                                        </a>
                                        <form id="read-form-{{ $contact->id }}" action="{{ route('admin.contacts.mark-as-read', $contact->id) }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    @endif
                                    <a href="#" onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer ce message ?')){ document.getElementById('delete-form-{{ $contact->id }}').submit(); }" class="text-red-600 hover:text-red-900" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <form id="delete-form-{{ $contact->id }}" action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50">
                {{ $contacts->links() }}
            </div>
        </div>
        
        <!-- Formulaire pour les actions groupées -->
        <form id="bulk-mark-read-form" action="{{ route('admin.contacts.bulk-mark-as-read') }}" method="POST" style="display: none;">
            @csrf
            <div id="bulk-mark-read-inputs"></div>
        </form>
    @endif

    @push('scripts')
    <script>
        // Gestion de la sélection de tous les messages
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.message-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
        
        // Fonction pour confirmer et exécuter une action groupée
        function confirmBulkAction(action) {
            const checkboxes = document.querySelectorAll('.message-checkbox:checked');
            if (checkboxes.length === 0) {
                alert('Veuillez sélectionner au moins un message.');
                return;
            }
            
            if (action === 'delete') {
                if (!confirm(`Êtes-vous sûr de vouloir supprimer ${checkboxes.length} message(s) ?`)) {
                    return;
                }
                document.getElementById('bulk-form').submit();
            } else if (action === 'mark-read') {
                if (!confirm(`Êtes-vous sûr de vouloir marquer ${checkboxes.length} message(s) comme lu(s) ?`)) {
                    return;
                }
                
                // Copier les IDs sélectionnés dans le formulaire de marquage comme lu
                const container = document.getElementById('bulk-mark-read-inputs');
                container.innerHTML = '';
                
                checkboxes.forEach(checkbox => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'selected[]';
                    input.value = checkbox.value;
                    container.appendChild(input);
                });
                
                document.getElementById('bulk-mark-read-form').submit();
            }
        }
    </script>
    @endpush
@endsection