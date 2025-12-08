<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Nom -->
        <div>
            <x-input-label for="nom" value="Nom" />
            <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" value="{{ old('nom') }}" required autofocus />
            <x-input-error :messages="$errors->get('nom')" class="mt-2" />
        </div>

        <!-- Prénom -->
        <div class="mt-4">
            <x-input-label for="prenom" value="Prénom" />
            <x-text-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" value="{{ old('prenom') }}" required />
            <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Sexe -->
        <div class="mt-4">
            <x-input-label for="sexe" value="Sexe" />
            <select id="sexe" name="sexe" class="block mt-1 w-full border-gray-300 rounded-md" required>
                <option value="">-- Sélectionner --</option>
                <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
            </select>
            <x-input-error :messages="$errors->get('sexe')" class="mt-2" />
        </div>

        <!-- Date de naissance -->
        <div class="mt-4">
            <x-input-label for="date_naissance" value="Date de naissance" />
            <x-text-input id="date_naissance" class="block mt-1 w-full" type="date" name="date_naissance" value="{{ old('date_naissance') }}" />
            <x-input-error :messages="$errors->get('date_naissance')" class="mt-2" />
        </div>

        <!-- Photo -->
        <div class="mt-4">
            <x-input-label for="photo" value="Photo de profil (optionnel)" />
            <input id="photo" name="photo" type="file" class="block mt-1 w-full" accept="image/*">
            <x-input-error :messages="$errors->get('photo')" class="mt-2" />
        </div>

        <!-- Mot de passe -->
        <div class="mt-4">
            <x-input-label for="password" value="Mot de passe" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmation -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirmer le mot de passe" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Conditions -->
        <div class="mt-4 flex items-center">
            <input id="terms" type="checkbox" name="terms" class="mr-2" required>
            <label for="terms">J’accepte les conditions d’utilisation</label>
        </div>
        <x-input-error :messages="$errors->get('terms')" class="mt-2" />

        <!-- Bouton -->
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                Déjà inscrit ?
            </a>

            <x-primary-button class="ms-4">
                S’inscrire
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
