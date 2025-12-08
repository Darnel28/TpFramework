<x-guest-layout>
    <h2 class="text-2xl mb-4">Créer une contribution</h2>

    <form method="POST" action="{{ route('contribute.submit') }}" enctype="multipart/form-data">
        @csrf

        <!-- Titre -->
        <div>
            <x-input-label for="titre" value="Titre" />
            <x-text-input id="titre" name="titre" class="block mt-1 w-full" value="{{ old('titre') }}" required />
            <x-input-error :messages="$errors->get('titre')" class="mt-2" />
        </div>

        <!-- Région -->
        <div class="mt-4">
            <x-input-label for="region" value="Région" />
            <select id="region" name="region" class="block mt-1 w-full" required>
                <option value="">-- Sélectionner --</option>
                @foreach($regions as $region)
                    <option value="{{ $region->id_region }}">{{ $region->nom_region }}</option>
                @endforeach
            </select>
        </div>

        <!-- Langue -->
        <div class="mt-4">
            <x-input-label for="langue" value="Langue" />
            <select id="langue" name="langue" class="block mt-1 w-full" required>
                <option value="">-- Sélectionner --</option>
                @foreach($langues as $langue)
                    <option value="{{ $langue->id_langue }}">{{ $langue->nom_langue }}</option>
                @endforeach
            </select>
        </div>

        <!-- Texte -->
        <div class="mt-4">
            <x-input-label for="texte" value="Texte" />
            <textarea id="texte" name="texte" class="block mt-1 w-full" rows="6" required>{{ old('texte') }}</textarea>
        </div>

        <!-- Bouton -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button>Soumettre</x-primary-button>
        </div>
    </form>
</x-guest-layout>
