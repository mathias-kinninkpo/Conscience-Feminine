<!-- resources/views/admin/pages/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Gestion des pages')

@section('page-title', 'Gestion des pages')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Liste des pages</h2>
        <a href="{{ route('admin.pages.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition-colors duration-300 flex items-center">
            <i class="bi bi-plus-lg mr-2"></i> Ajouter une page
        </a>
    </div>

    @if($pages->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <img src="{{ asset('storage/images/empty.svg') }}" alt="Aucune page" class="w-32 h-32 mx-auto mb-4 opacity-50">
            <h3 class="text-lg font-medium text-gray-900 mb-1">Aucune page disponible</h3>
            <p class="text-gray-500 mb-6">Commencez par créer votre première page</p>
            <a href="{{ route('admin.pages.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors duration-300">
                <i class="bi bi-plus-lg mr-2"></i> Créer une page
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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de création</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">URL</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pages as $page)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($page->image)
                                            <img class="h-10 w-10 rounded-md object-cover" src="{{ asset('storage/' . $page->image) }}" alt="{{ $page->title }}">
                                        @else
                                            <div class="h-10 w-10 rounded-md bg-gray-200 flex items-center justify-center">
                                                <i class="bi bi-file-earmark-text text-gray-500"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $page->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $page->slug }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $page->created_at->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('page', $page->slug) }}" target="_blank" class="inline-flex items-center px-2.5 py-0.5 rounded-md bg-blue-100 text-blue-800 text-xs">
                                        <i class="bi bi-box-arrow-up-right mr-1"></i> Voir
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.pages.edit', $page->id) }}" class="text-blue-600 hover:text-blue-900 mr-3" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="#" onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer cette page ?')){ document.getElementById('delete-form-{{ $page->id }}').submit(); }" class="text-red-600 hover:text-red-900" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                    <form id="delete-form-{{ $page->id }}" action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" style="display: none;">
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
                {{ $pages->links() }}
            </div>
        </div>
    @endif
@endsection