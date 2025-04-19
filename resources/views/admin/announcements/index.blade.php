@extends('layouts.admin')

@section('title', 'Gestion des annonces')

@section('page-title', 'Gestion des annonces')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Liste des annonces</h2>
        <a href="{{ route('admin.announcements.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition-colors duration-300 flex items-center">
            <i class="bi bi-plus-lg mr-2"></i> Ajouter une annonce
        </a>
    </div>

    @if($announcements->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <img src="{{ asset('storage/images/empty.svg') }}" alt="Aucune annonce" class="w-32 h-32 mx-auto mb-4 opacity-50">
            <h3 class="text-lg font-medium text-gray-900 mb-1">Aucune annonce disponible</h3>
            <p class="text-gray-500 mb-6">Commencez par créer votre première annonce</p>
            <a href="{{ route('admin.announcements.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors duration-300">
                <i class="bi bi-plus-lg mr-2"></i> Créer une annonce
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de publication</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auteur</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de création</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($announcements as $announcement)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($announcement->image)
                                            <img class="h-10 w-10 rounded-md object-cover" src="{{ asset('storage/' . $announcement->image) }}" alt="{{ $announcement->title }}">
                                        @else
                                            <div class="h-10 w-10 rounded-md bg-gray-200 flex items-center justify-center">
                                                <i class="bi bi-megaphone text-gray-500"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $announcement->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($announcement->published_at)->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $announcement->user->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $announcement->created_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.announcements.show', $announcement->id) }}" class="text-primary hover:text-primary-dark mr-3" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="text-blue-600 hover:text-blue-900 mr-3" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="#" onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')){ document.getElementById('delete-form-{{ $announcement->id }}').submit(); }" class="text-red-600 hover:text-red-900" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <form id="delete-form-{{ $announcement->id }}" action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" style="display: none;">
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
                {{ $announcements->links() }}
            </div>
        </div>
    @endif
@endsection