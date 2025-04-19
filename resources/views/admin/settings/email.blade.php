<!-- resources/views/admin/settings/email.blade.php -->
@extends('layouts.admin')

@section('title', 'Paramètres d\'email')

@section('page-title', 'Paramètres d\'email')

@section('content')
    <div class="mb-6">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.settings') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors duration-300">
                Général
            </a>
            <a href="{{ route('admin.settings.appearance') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors duration-300">
                Apparence
            </a>
            <a href="{{ route('admin.settings.email') }}" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors duration-300">
                Email
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-800">Paramètres d'email</h2>
        </div>
        
        <form action="{{ route('admin.settings.email.update') }}" method="POST">
            @csrf
            
            <div class="p-6">
                <!-- Configuration SMTP -->
                <h3 class="text-md font-medium text-gray-700 mb-4">Configuration SMTP</h3>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-8">
                    <!-- Pilote d'email -->
                    <div>
                        <label for="mail_mailer" class="block text-sm font-medium text-gray-700 mb-1">Pilote d'email <span class="text-red-600">*</span></label>
                        <select id="mail_mailer" name="mail_mailer" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            <option value="smtp" {{ setting('mail_mailer') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                            <option value="sendmail" {{ setting('mail_mailer') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                            <option value="mailgun" {{ setting('mail_mailer') == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                            <option value="ses" {{ setting('mail_mailer') == 'ses' ? 'selected' : '' }}>Amazon SES</option>
                            <option value="postmark" {{ setting('mail_mailer') == 'postmark' ? 'selected' : '' }}>Postmark</option>
                            <option value="log" {{ setting('mail_mailer') == 'log' ? 'selected' : '' }}>Log</option>
                            <option value="array" {{ setting('mail_mailer') == 'array' ? 'selected' : '' }}>Array (Pour les tests)</option>
                        </select>
                        @error('mail_mailer')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Hôte SMTP -->
                    <div>
                        <label for="mail_host" class="block text-sm font-medium text-gray-700 mb-1">Hôte SMTP <span class="text-red-600">*</span></label>
                        <input type="text" id="mail_host" name="mail_host" value="{{ old('mail_host', setting('mail_host')) }}" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="smtp.example.com">
                        @error('mail_host')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Port SMTP -->
                    <div>
                        <label for="mail_port" class="block text-sm font-medium text-gray-700 mb-1">Port SMTP <span class="text-red-600">*</span></label>
                        <input type="number" id="mail_port" name="mail_port" value="{{ old('mail_port', setting('mail_port', 587)) }}" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="587">
                        @error('mail_port')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Chiffrement SMTP -->
                    <div>
                        <label for="mail_encryption" class="block text-sm font-medium text-gray-700 mb-1">Chiffrement SMTP</label>
                        <select id="mail_encryption" name="mail_encryption"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            <option value="" {{ setting('mail_encryption') == '' ? 'selected' : '' }}>Aucun</option>
                            <option value="tls" {{ setting('mail_encryption') == 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ setting('mail_encryption') == 'ssl' ? 'selected' : '' }}>SSL</option>
                        </select>
                        @error('mail_encryption')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Nom d'utilisateur SMTP -->
                    <div>
                        <label for="mail_username" class="block text-sm font-medium text-gray-700 mb-1">Nom d'utilisateur SMTP</label>
                        <input type="text" id="mail_username" name="mail_username" value="{{ old('mail_username', setting('mail_username')) }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="utilisateur@example.com">
                        @error('mail_username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Mot de passe SMTP -->
                    <div>
                        <label for="mail_password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe SMTP</label>
                        <input type="password" id="mail_password" name="mail_password" value="{{ old('mail_password', setting('mail_password')) }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="••••••••">
                        @error('mail_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Configuration de l'expéditeur -->
                <h3 class="text-md font-medium text-gray-700 mb-4">Configuration de l'expéditeur</h3>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-8">
                    <!-- Adresse d'expéditeur -->
                    <div>
                        <label for="mail_from_address" class="block text-sm font-medium text-gray-700 mb-1">Adresse d'expéditeur <span class="text-red-600">*</span></label>
                        <input type="email" id="mail_from_address" name="mail_from_address" value="{{ old('mail_from_address', setting('mail_from_address')) }}" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="noreply@example.com">
                        @error('mail_from_address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Nom d'expéditeur -->
                    <div>
                        <label for="mail_from_name" class="block text-sm font-medium text-gray-700 mb-1">Nom d'expéditeur <span class="text-red-600">*</span></label>
                        <input type="text" id="mail_from_name" name="mail_from_name" value="{{ old('mail_from_name', setting('mail_from_name')) }}" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="ONG Conscience Féminine">
                        @error('mail_from_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Test d'email -->
                <h3 class="text-md font-medium text-gray-700 mb-4">Tester la configuration</h3>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <p class="text-sm text-gray-600 mb-4">Envoyez un email de test pour vérifier votre configuration SMTP.</p>
                    <div class="flex items-end gap-4">
                        <div class="flex-grow">
                            <label for="test_email" class="block text-sm font-medium text-gray-700 mb-1">Adresse de test</label>
                            <input type="email" id="test_email" name="test_email" value="{{ old('test_email') }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                   placeholder="votre@email.com">
                        </div>
                        <button type="button" id="send-test-email" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors duration-300">
                            <i class="bi bi-envelope-paper mr-2"></i> Envoyer un test
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition-colors duration-300">
                    <i class="bi bi-save mr-2"></i> Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>

    <!-- Formulaire séparé pour l'envoi d'email de test -->
    <form id="test-email-form" action="{{ route('admin.settings.email.test') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="test_email" id="hidden_test_email">
    </form>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Envoyer un email de test
            document.getElementById('send-test-email').addEventListener('click', function() {
                const emailInput = document.getElementById('test_email');
                const emailValue = emailInput.value.trim();
                
                if (!emailValue) {
                    alert('Veuillez entrer une adresse email de test.');
                    emailInput.focus();
                    return;
                }
                
                if (!isValidEmail(emailValue)) {
                    alert('Veuillez entrer une adresse email valide.');
                    emailInput.focus();
                    return;
                }
                
                document.getElementById('hidden_test_email').value = emailValue;
                document.getElementById('test-email-form').submit();
            });
            
            // Validation d'email simple
            function isValidEmail(email) {
                const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }
        });
    </script>
    @endpush
@endsection