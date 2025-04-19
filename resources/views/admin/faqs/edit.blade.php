<!-- resources/views/admin/faqs/edit.blade.php -->
@extends('layouts.admin')

@section('title', 'Modifier une FAQ')

@section('page-title', 'Modifier une FAQ')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.faqs.index') }}" class="inline-flex items-center text-gray-600 hover:text-primary">
            <i class="bi bi-arrow-left mr-2"></i> Retour à la liste
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Modifier la question fréquemment posée</h2>
            
            <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Question -->
                    <div>
                        <label for="question" class="block text-sm font-medium text-gray-700 mb-1">Question <span class="text-red-600">*</span></label>
                        <input type="text" id="question" name="question" value="{{ old('question', $faq->question) }}" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="Entrez la question">
                        @error('question')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Réponse -->
                    <div>
                        <label for="answer" class="block text-sm font-medium text-gray-700 mb-1">Réponse <span class="text-red-600">*</span></label>
                        <textarea id="answer" name="answer" rows="8" required
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                  placeholder="Entrez la réponse à la question">{{ old('answer', $faq->answer) }}</textarea>
                        @error('answer')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('admin.faqs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md mr-2 hover:bg-gray-400 transition-colors duration-300">
                        Annuler
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors duration-300">
                        <i class="bi bi-check-lg mr-2"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection