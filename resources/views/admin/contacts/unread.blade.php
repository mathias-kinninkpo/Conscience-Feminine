<!-- resources/views/admin/contacts/unread.blade.php -->
@extends('layouts.admin')

@section('title', 'Messages non lus')

@section('page-title', 'Messages non lus')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Messages non lus</h2>
            <p class="text-sm text-gray-600 mt-1">Voir uniquement les messages qui n'ont pas encore été lus</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.contacts.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors duration-300 flex items-center">
                <i class="bi bi-list mr-2"></i> Tous les messages
            </a>
        </div>
    </div>

    @if($contacts->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <img src="{{ asset('storage/images/empty.svg') }}" alt="Aucun message non lu" class="w-32 h-32 mx-auto mb-4 opacity-50">
            <h3 class="text-lg font-medium text-gray-900 mb-1">Aucun message non lu</h3>
            <p class="text-gray-500">Tous vos messages ont été marqués comme lus.</p>
            <a href="{{ route('admin.contacts.index') }}" class="mt-4 inline-flex items-center text-primary hover:text-primary-dark">
                <i class="bi bi-arrow-left mr-2"></i>
                Retour à tous les messages
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <form action="{{ route('admin.contacts.bulk-mark-as-read') }}" method="POST" id="bulk-form">
                    @csrf
                    <div class="flex flex-wrap items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="select-all" class="rounded text-primary focus:ring-primary">
                            <label for="select-all" class="text-sm text-gray-700">Tout sélectionner</label>
                        </div>
                        <div class="flex items-center space-x-2 mt-2 sm:mt-0">
                            <button type="submit" class="text-sm bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition-colors duration-200 flex items-center">
                                <i class="bi bi-envelope-open mr-1"></i> Marquer comme lu
                            </button>
                            <button type="button" onclick="confirmBulkDelete()" class="text-sm bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition-colors duration-200 flex items-center">
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
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($contacts as $contact)
                            <tr class="bg-yellow-50">
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
                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ Str::limit($contact->subject, 50) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $contact->created_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.contacts.show', $contact->id) }}" class="text-primary hover:text-primary-dark mr-3" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('read-form-{{ $contact->id }}').submit();" class="text-green-600 hover:text-green-900 mr-3" title="Marquer comme lu">
                                        <i class="bi bi-envelope-open"></i>
                                    </a>
                                    <form id="read-form-{{ $contact->id }}" action="{{ route('admin.contacts.mark-as-read', $contact->id) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
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
        
        <!-- Formulaire pour les suppressions groupées -->
        <form id="bulk-delete-form" action="{{ route('admin.contacts.bulk-delete') }}" method="POST" style="display: none;">
            @csrf
            <div id="bulk-delete-inputs"></div>
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
        
        // Fonction pour confirmer et exécuter une suppression groupée
        function confirmBulkDelete() {
            const checkboxes = document.querySelectorAll('.message-checkbox:checked');
            if (checkboxes.length === 0) {
                alert('Veuillez sélectionner au moins un message.');
                return;
            }
            
            if (confirm(`Êtes-vous sûr de vouloir supprimer ${checkboxes.length} message(s) ?`)) {
                // Copier les IDs sélectionnés dans le formulaire de suppression
                const container = document.getElementById('bulk-delete-inputs');
                container.innerHTML = '';
                
                checkboxes.forEach(checkbox => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'selected[]';
                    input.value = checkbox.value;
                    container.appendChild(input);
                });
                
                document.getElementById('bulk-delete-form').submit();
            }
        }
    </script>
    @endpush
@endsection