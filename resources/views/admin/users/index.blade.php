<!-- resources/views/admin/users/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Gestion des utilisateurs')

@section('page-title', 'Gestion des utilisateurs')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Liste des utilisateurs</h2>
        <a href="{{ route('admin.users.create') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition-colors duration-300 flex items-center">
            <i class="bi bi-person-plus-fill mr-2"></i> Ajouter un utilisateur
        </a>
    </div>

    @if($users->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <img src="{{ asset('storage/images/empty.svg') }}" alt="Aucun utilisateur" class="w-32 h-32 mx-auto mb-4 opacity-50">
            <h3 class="text-lg font-medium text-gray-900 mb-1">Aucun utilisateur disponible</h3>
            <p class="text-gray-500 mb-6">Commencez par créer votre premier utilisateur</p>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors duration-300">
                <i class="bi bi-person-plus-fill mr-2"></i> Créer un utilisateur
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de création</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dernière connexion</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                            <span class="text-gray-500 font-medium">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $user->created_at->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">
                                        @if($user->email_verified_at)
                                            {{ \Carbon\Carbon::parse($user->email_verified_at)->format('d/m/Y') }}
                                        @else
                                            Jamais
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-900 mr-3" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <a href="#" onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')){ document.getElementById('delete-form-{{ $user->id }}').submit(); }" class="text-red-600 hover:text-red-900" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                        <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @else
                                        <span class="text-gray-400" title="Vous ne pouvez pas supprimer votre propre compte">
                                            <i class="bi bi-trash"></i>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50">
                {{ $users->links() }}
            </div>
        </div>
    @endif
@endsection