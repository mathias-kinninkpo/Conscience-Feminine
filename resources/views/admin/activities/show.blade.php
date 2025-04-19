<!-- resources/views/admin/activities/show.blade.php -->
@extends('layouts.admin')

@section('title', 'Détails de l\'activité')

@section('page-title', 'Détails de l\'activité')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.activities.index') }}" class="inline-flex items-center text-gray-600 hover:text-primary">
            <i class="bi bi-arrow-left mr-2"></i> Retour à la liste
        </a>
        <div class="flex space-x-2">
            <a href="{{ route('admin.activities.edit', $activity->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors duration-300">
                <i class="bi bi-pencil mr-2"></i> Modifier
            </a>
            <a href="#" onclick="event.preventDefault(); if(confirm('Êtes-vous sûr de vouloir supprimer cette activité ?')){ document.getElementById('delete-form').submit(); }" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors duration-300">
                <i class="bi bi-trash mr-2"></i> Supprimer
            </a>
            <form id="delete-form" action="{{ route('admin.activities.destroy', $activity->id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $activity->title }}</h2>
                <div class="flex flex-wrap items-center text-gray-500 text-sm mb-4">
                    <div class="flex items-center mr-4 mb-2">
                        <i class="bi bi-calendar3 mr-1"></i>
                        <span>Date : {{ \Carbon\Carbon::parse($activity->activity_date)->format('d/m/Y') }}</span>
                    </div>
                    @if($activity->location)
                    <div class="flex items-center mr-4 mb-2">
                        <i class="bi bi-geo-alt mr-1"></i>
                        <span>Lieu : {{ $activity->location }}</span>
                    </div>
                    @endif
                    <div class="flex items-center mr-4 mb-2">
                        <i class="bi bi-person mr-1"></i>
                        <span>Responsable : {{ $activity->user->name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center mb-2">
                        <i class="bi bi-clock mr-1"></i>
                        <span>Créée le {{ $activity->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                </div>
                
                @if($activity->image)
                    <div class="mb-6">
                        <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->title }}" class="w-full max-h-96 object-cover rounded-lg">
                    </div>
                @endif
                
                <div class="prose max-w-none mt-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Description</h3>
                    <div class="text-gray-700">
                        {!! nl2br(e($activity->description)) !!}
                    </div>
                </div>
            </div>
            
            <div class="mt-8 border-t pt-4">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Informations supplémentaires</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p class="text-sm font-medium text-gray-500">Date de création</p>
                        <p class="text-gray-800">{{ $activity->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p class="text-sm font-medium text-gray-500">Dernière modification</p>
                        <p class="text-gray-800">{{ $activity->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p class="text-sm font-medium text-gray-500">Statut</p>
                        @if($activity->activity_date < now())
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="bi bi-check-circle-fill mr-1"></i> Passée
                            </span>
                        @elseif($activity->activity_date->diffInDays(now()) <= 7)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="bi bi-clock-fill mr-1"></i> Prochainement
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="bi bi-calendar-event-fill mr-1"></i> À venir
                            </span>
                        @endif
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p class="text-sm font-medium text-gray-500">ID</p>
                        <p class="text-gray-800">{{ $activity->id }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection