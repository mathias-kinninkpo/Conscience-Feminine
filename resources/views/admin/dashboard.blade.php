@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('page-title', 'Tableau de bord')

@section('content')
    <!-- Statistiques -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Activités -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 flex items-center">
                <div class="rounded-full bg-blue-100 p-3 mr-4">
                    <i class="bi bi-calendar-event text-xl text-blue-600"></i>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">
                        Activités
                    </div>
                    <div class="text-3xl font-semibold text-gray-900">
                        {{ $stats['activities_count'] }}
                    </div>
                </div>
            </div>
            <div class="bg-blue-50 px-6 py-2">
                <a href="{{ route('admin.activities.index') }}" class="text-sm text-blue-600 font-medium hover:text-blue-800 flex items-center">
                    Voir toutes <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
        
        <!-- Annonces -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 flex items-center">
                <div class="rounded-full bg-green-100 p-3 mr-4">
                    <i class="bi bi-megaphone text-xl text-green-600"></i>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">
                        Annonces
                    </div>
                    <div class="text-3xl font-semibold text-gray-900">
                        {{ $stats['announcements_count'] }}
                    </div>
                </div>
            </div>
            <div class="bg-green-50 px-6 py-2">
                <a href="{{ route('admin.announcements.index') }}" class="text-sm text-green-600 font-medium hover:text-green-800 flex items-center">
                    Voir toutes <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
        
        <!-- Messages non lus -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 flex items-center">
                <div class="rounded-full bg-yellow-100 p-3 mr-4">
                    <i class="bi bi-envelope text-xl text-yellow-600"></i>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">
                        Messages non lus
                    </div>
                    <div class="text-3xl font-semibold text-gray-900">
                        {{ $stats['unread_messages_count'] }}
                    </div>
                </div>
            </div>
            <div class="bg-yellow-50 px-6 py-2">
                <a href="{{ route('admin.contacts.unread') }}" class="text-sm text-yellow-600 font-medium hover:text-yellow-800 flex items-center">
                    Voir tous <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
        
        <!-- Utilisateurs -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 flex items-center">
                <div class="rounded-full bg-purple-100 p-3 mr-4">
                    <i class="bi bi-people text-xl text-purple-600"></i>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">
                        Utilisateurs
                    </div>
                    <div class="text-3xl font-semibold text-gray-900">
                        {{ $stats['users_count'] }}
                    </div>
                </div>
            </div>
            <div class="bg-purple-50 px-6 py-2">
                <a href="{{ route('admin.users.index') }}" class="text-sm text-purple-600 font-medium hover:text-purple-800 flex items-center">
                    Voir tous <i class="bi bi-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Dernières activités -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Dernières activités</h3>
                    <a href="{{ route('admin.activities.create') }}" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <i class="bi bi-plus-lg mr-2"></i>
                        Ajouter
                    </a>
                </div>
                
                @if($latestActivities->isEmpty())
                    <div class="text-center py-8">
                        <img src="{{ asset('storage/images/empty.svg') }}" alt="Aucune activité" class="w-32 h-32 mx-auto mb-4 opacity-50">
                        <p class="text-gray-500">Aucune activité n'a été ajoutée pour le moment.</p>
                        <a href="{{ route('admin.activities.create') }}" class="mt-4 inline-flex items-center text-primary hover:text-primary-dark">
                            <i class="bi bi-plus-circle mr-2"></i>
                            Créer la première activité
                        </a>
                    </div>
                @else
                    <div class="overflow-y-auto max-h-80 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                        <ul class="divide-y divide-gray-200">
                            @foreach($latestActivities as $activity)
                                <li class="py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            @if($activity->image)
                                                <img class="h-12 w-12 rounded-md object-cover" src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->title }}">
                                            @else
                                                <div class="h-12 w-12 rounded-md bg-gray-200 flex items-center justify-center text-gray-400">
                                                    <i class="bi bi-calendar-event text-2xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $activity->title }}
                                            </p>
                                            <p class="text-sm text-gray-500 truncate">
                                                <i class="bi bi-calendar2 mr-1"></i>
                                                {{ \Carbon\Carbon::parse($activity->activity_date)->format('d/m/Y') }}
                                                @if($activity->location)
                                                    <span class="mx-2">•</span>
                                                    <i class="bi bi-geo-alt mr-1"></i>
                                                    {{ $activity->location }}
                                                @endif
                                            </p>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.activities.edit', $activity->id) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-primary bg-primary-light bg-opacity-10 hover:bg-opacity-20 focus:outline-none focus:bg-opacity-20">
                                                Éditer
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mt-4 text-right">
                        <a href="{{ route('admin.activities.index') }}" class="text-sm font-medium text-primary hover:text-primary-dark">
                            Voir toutes les activités <i class="bi bi-arrow-right ml-1"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Dernières annonces -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Dernières annonces</h3>
                    <a href="{{ route('admin.announcements.create') }}" class="inline-flex items-center px-4 py-2 bg-secondary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                        <i class="bi bi-plus-lg mr-2"></i>
                        Ajouter
                    </a>
                </div>
                
                @if($latestAnnouncements->isEmpty())
                    <div class="text-center py-8">
                        <img src="{{ asset('storage/images/empty.svg') }}" alt="Aucune annonce" class="w-32 h-32 mx-auto mb-4 opacity-50">
                        <p class="text-gray-500">Aucune annonce n'a été ajoutée pour le moment.</p>
                        <a href="{{ route('admin.announcements.create') }}" class="mt-4 inline-flex items-center text-secondary hover:text-secondary-dark">
                            <i class="bi bi-plus-circle mr-2"></i>
                            Créer la première annonce
                        </a>
                    </div>
                @else
                    <div class="overflow-y-auto max-h-80 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                        <ul class="divide-y divide-gray-200">
                            @foreach($latestAnnouncements as $announcement)
                                <li class="py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            @if($announcement->image)
                                                <img class="h-12 w-12 rounded-md object-cover" src="{{ asset('storage/' . $announcement->image) }}" alt="{{ $announcement->title }}">
                                            @else
                                                <div class="h-12 w-12 rounded-md bg-gray-200 flex items-center justify-center text-gray-400">
                                                    <i class="bi bi-megaphone text-2xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $announcement->title }}
                                            </p>
                                            <p class="text-sm text-gray-500 truncate">
                                                <i class="bi bi-calendar2 mr-1"></i>
                                                {{ \Carbon\Carbon::parse($announcement->published_at)->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-secondary bg-secondary-light bg-opacity-10 hover:bg-opacity-20 focus:outline-none focus:bg-opacity-20">
                                                Éditer
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mt-4 text-right">
                        <a href="{{ route('admin.announcements.index') }}" class="text-sm font-medium text-secondary hover:text-secondary-dark">
                            Voir toutes les annonces <i class="bi bi-arrow-right ml-1"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Derniers messages -->
    <div class="mt-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Derniers messages</h3>
                </div>
                
                @if($latestMessages->isEmpty())
                    <div class="text-center py-8">
                        <img src="{{ asset('storage/images/empty.svg') }}" alt="Aucun message" class="w-32 h-32 mx-auto mb-4 opacity-50">
                        <p class="text-gray-500">Aucun message n'a été reçu pour le moment.</p>
                    </div>
                @else
                    <div class="overflow-y-auto max-h-96 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50 sticky top-0 z-10">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Expéditeur
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Sujet
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Statut
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($latestMessages as $message)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                        <span class="text-gray-500 font-medium">
                                                            {{ strtoupper(substr($message->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $message->name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $message->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 max-w-xs truncate">
                                                    {{ $message->subject }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">
                                                    {{ $message->created_at->format('d/m/Y H:i') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($message->is_read)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Lu
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Non lu
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('admin.contacts.show', $message->id) }}" class="text-primary hover:text-primary-dark mr-3">
                                                    Voir
                                                </a>
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $message->id }}').submit();" class="text-red-600 hover:text-red-900">
                                                    Supprimer
                                                </a>
                                                <form id="delete-form-{{ $message->id }}" action="{{ route('admin.contacts.destroy', $message->id) }}" method="POST" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4 text-right">
                        <a href="{{ route('admin.contacts.index') }}" class="text-sm font-medium text-primary hover:text-primary-dark">
                            Voir tous les messages <i class="bi bi-arrow-right ml-1"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        /* Styles pour les barres de défilement personnalisées */
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
        
        /* Pour Firefox */
        .scrollbar-thin {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f1f1f1;
        }
    </style>
    @endpush
@endsection