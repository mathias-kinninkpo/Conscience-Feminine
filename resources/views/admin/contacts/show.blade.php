<!-- resources/views/admin/contacts/show.blade.php -->
@extends('layouts.admin')

@section('title', 'Détails du message')

@section('page-title', 'Détails du message')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-600 hover:text-primary">
            <i class="bi bi-arrow-left mr-2"></i> Retour aux messages
        </a>
        <div class="flex space-x-2">
            @if($contact->is_read)
                <a href="#" onclick="event.preventDefault(); document.getElementById('unread-form').submit();" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition-colors duration-300">
                    <i class="bi bi-envelope mr-2"></i> Marquer comme non lu
                </a>
                <form id="unread-form" action="{{ route('admin.contacts.mark-as-unread', $contact->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="#" onclick="event.preventDefault(); document.getElementById('read-form').submit();" class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors duration-300">
                    <i class="bi bi-envelope-open mr-2"></i> Marquer comme lu
                </a>
                <form id="read-form" action="{{ route('admin.contacts.mark-as-read', $contact->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endif
            <a href="#" onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer ce message ?')){ document.getElementById('delete-form').submit(); }" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors duration-300">
                <i class="bi bi-trash mr-2"></i> Supprimer
            </a>
            <form id="delete-form" action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $contact->subject }}</h2>
                    <div class="mt-2 flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                            <span class="text-gray-500 font-medium">{{ strtoupper(substr($contact->name, 0, 1)) }}</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ $contact->name }}</p>
                            <p class="text-sm text-gray-500">
                                <a href="mailto:{{ $contact->email }}" class="hover:underline">{{ $contact->email }}</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $contact->is_read ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        <i class="bi {{ $contact->is_read ? 'bi-envelope-open' : 'bi-envelope' }} mr-1"></i>
                        {{ $contact->is_read ? 'Lu' : 'Non lu' }}
                    </span>
                    <p class="text-sm text-gray-500 mt-2">{{ $contact->created_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>
            
            <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h3 class="text-lg font-medium text-gray-800 mb-3">Message</h3>
                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($contact->message)) !!}
                </div>
            </div>
            
            <div class="mt-8 border-t pt-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Actions rapides</h3>
                <div class="flex space-x-4">
                    <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors duration-300">
                        <i class="bi bi-reply mr-2"></i> Répondre par email
                    </a>
                    <button type="button" onclick="copyToClipboard('{{ $contact->email }}')" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors duration-300">
                        <i class="bi bi-clipboard mr-2"></i> Copier l'email
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Adresse email copiée dans le presse-papier : ' + text);
            }, function(err) {
                console.error('Impossible de copier le texte: ', err);
            });
        }
    </script>
    @endpush
@endsection