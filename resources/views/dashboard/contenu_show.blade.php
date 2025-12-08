@extends('dashboard.layout')

@section('content')
<section class="content-section">
    <div class="section-header">
        <h1>Contenu: {{ $contenu->titre }}</h1>
        <a href="{{ route('admin.contenu.edit', $contenu->id_contenu) }}" class="btn btn-primary">Modifier</a>
    </div>
    <div style="margin-top:12px">
        <div><strong>Auteur:</strong> @if($contenu->auteur) {{ $contenu->auteur->nom }} {{ $contenu->auteur->prenom }} @endif</div>
        <div><strong>Modérateur:</strong> @if($contenu->moderateur) {{ $contenu->moderateur->nom }} {{ $contenu->moderateur->prenom }} @endif</div>
        <div style="margin-top:12px">{!! nl2br(e($contenu->texte)) !!}</div>
        @if(!empty($contenu->image))
            <div style="margin-top:10px">
                <h4>Image</h4>
                <img src="{{ $contenu->image }}" alt="image" style="max-width:100%; height:auto;" />
                <a href="{{ $contenu->image }}" download class="btn btn-secondary" style="display:inline-block; margin-left:8px;">Télécharger</a>
            </div>
        @endif
        @if(!empty($contenu->video))
            <div style="margin-top:10px">
                <h4>Vidéo</h4>
                <video src="{{ $contenu->video }}" controls style="max-width:100%; height:auto;"></video>
                <a href="{{ $contenu->video }}" download class="btn btn-secondary" style="display:inline-block; margin-left:8px;">Télécharger</a>
            </div>
        @endif
    </div>
</section>
@endsection
