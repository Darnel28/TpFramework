@extends('Moderateur.layout')

@section('content')
<section class="content-section">
    <div class="section-header">
        <h1>Tableau de bord — Modérateur</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Widgets statiques similaires à l'accueil admin -->
    <div class="dashboard-widgets" style="display:flex; gap:16px; margin-bottom:20px;">
        <div class="widget card" style="flex:1; padding:12px; background:#fff; border:1px solid #e6e6e6; border-radius:6px;">
            <h3>Total contenus</h3>
            <p style="font-size:20px; font-weight:700;">{{ $total ?? '-' }}</p>
        </div>
        <div class="widget card" style="flex:1; padding:12px; background:#fff; border:1px solid #e6e6e6; border-radius:6px;">
            <h3>En attente</h3>
            <p style="font-size:20px; font-weight:700; color:#e67e22;">{{ $pendingCount ?? ($pending->count() ?? 0) }}</p>
        </div>
        <div class="widget card" style="flex:1; padding:12px; background:#fff; border:1px solid #e6e6e6; border-radius:6px;">
            <h3>Publiés</h3>
            <p style="font-size:20px; font-weight:700; color:#27ae60;">{{ $publishedCount ?? '-' }}</p>
        </div>
        <div style="display:flex; align-items:center;">
            <a href="{{ url('/contribuer') }}" class="btn btn-primary" style="margin-left:8px; padding:10px 14px; background:#2d7ff9; color:#fff; border-radius:6px; text-decoration:none;"><i class="fas fa-plus"></i> Ajouter un contenu</a>
        </div>
    </div>

    <!-- Raccourcis et aperçu: pas de table ici — la liste complète est sur /moderateur/contenus -->
    <div class="dashboard-shortcuts" style="display:flex; gap:20px; flex-wrap:wrap; margin-top:10px;">
        <div class="card" style="flex:1; min-width:220px; padding:16px; background:#fff; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.06);">
            <h4 style="margin:0 0 8px 0;">Contenus en attente</h4>
            <p style="margin:0; font-size:20px; font-weight:700; color:#e67e22;">{{ $pendingCount ?? ($pending->count() ?? 0) }}</p>
            <a href="{{ url('/moderateur/contenus') }}" style="display:inline-block; margin-top:12px; color:#2d7ff9; text-decoration:none;">Voir la liste complète →</a>
        </div>

        <div class="card" style="flex:1; min-width:220px; padding:16px; background:#fff; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.06);">
            <h4 style="margin:0 0 8px 0;">Total contenus</h4>
            <p style="margin:0; font-size:20px; font-weight:700;">{{ $total ?? '-' }}</p>
            <a href="{{ url('/admin/histoires') }}" style="display:inline-block; margin-top:12px; color:#2d7ff9; text-decoration:none;">Gérer les contenus →</a>
        </div>

        <div class="card" style="flex:1; min-width:220px; padding:16px; background:#fff; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.06);">
            <h4 style="margin:0 0 8px 0;">Contenus publiés</h4>
            <p style="margin:0; font-size:20px; font-weight:700; color:#27ae60;">{{ $publishedCount ?? '-' }}</p>
            <a href="{{ url('/contenus') }}" style="display:inline-block; margin-top:12px; color:#2d7ff9; text-decoration:none;">Voir les contenus publics →</a>
        </div>

        <div class="card" style="flex:1; min-width:220px; padding:16px; background:#fff; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.06);">
            <h4 style="margin:0 0 8px 0;">Ajouter un contenu</h4>
            <p style="margin:0 0 8px 0;">Créer rapidement un nouveau contenu en tant que modérateur.</p>
            <a href="{{ url('/contribuer') }}" class="btn btn-primary" style="display:inline-block; padding:8px 12px; background:#2d7ff9; color:#fff; border-radius:6px; text-decoration:none;">Créer un contenu</a>
        </div>
    </div>
</section>
@endsection
