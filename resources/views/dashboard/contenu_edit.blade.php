@extends('dashboard.layout')

@section('content')
<section class="content-section">
    <div class="section-header">
        <h1>Modifier le contenu</h1>
    </div>

    <form method="POST" action="{{ url('/admin/contenu/'.$contenu->id_contenu) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>
            <label>Titre</label>
            <input type="text" name="titre" class="form-control" value="{{ $contenu->titre }}" required>
        </div>
        <div>
            <label>Texte</label>
            <textarea name="texte" class="form-control" rows="6">{{ $contenu->texte }}</textarea>
        </div>
        <div class="grid-2">
            <div>
                <label>Région</label>
                <select name="id_region" class="form-control" required>
                    <option value="">--</option>
                    @foreach($regions as $r)
                        <option value="{{ $r->id_region }}" {{ $contenu->id_region == $r->id_region ? 'selected' : '' }}>{{ $r->nom_region }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Langue</label>
                <select name="id_langue" class="form-control" required>
                    <option value="">--</option>
                    @foreach($langues as $l)
                        <option value="{{ $l->id_langue }}" {{ $contenu->id_langue == $l->id_langue ? 'selected' : '' }}>{{ $l->nom_langue }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid-2">
            <div>
                <label>Modérateur</label>
                <select name="id_moderateur" class="form-control">
                    <option value="">--</option>
                    @foreach($moderateurs as $m)
                        <option value="{{ $m->id_utilisateur }}" {{ $contenu->id_moderateur == $m->id_utilisateur ? 'selected' : '' }}>{{ $m->nom }} {{ $m->prenom }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Auteur</label>
                <select name="id_auteur" class="form-control" required>
                    @foreach($auteurs as $a)
                        <option value="{{ $a->id_utilisateur }}" {{ $contenu->id_auteur == $a->id_utilisateur ? 'selected' : '' }}>{{ $a->nom }} {{ $a->prenom }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label>Image</label>
            <input type="file" name="image">
            @if(!empty($contenu->image))
                <img src="{{ $contenu->image }}" style="max-width:120px; display:block; margin-top:6px;" />
                <a href="{{ $contenu->image }}" download class="btn btn-secondary">Télécharger</a>
            @endif
        </div>
        <div>
            <label>Vidéo</label>
            <input type="file" name="video" accept="video/*">
            @if(!empty($contenu->video))
                <video src="{{ $contenu->video }}" controls style="max-width:100%; display:block; margin-top:6px;"></video>
                <a href="{{ $contenu->video }}" download class="btn btn-secondary">Télécharger</a>
            @endif
        </div>
        <div style="margin-top:12px; text-align:right;">
            <a href="{{ url('/admin/histoires') }}" class="btn btn-secondary">Retour</a>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </form>
</section>
@endsection
