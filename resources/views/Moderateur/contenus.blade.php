@extends('Moderateur.layout')

@section('content')
<section class="content-section">
    <div class="section-header">
        <h1>Contenus en attente</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Extrait</th>
                    <th>Date création</th>
                    <th>Région</th>
                    <th>Langue</th>
                    <th>Type</th>
                    <th>Auteur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pending as $c)
                <tr>
                    <td>#{{ $c->id_contenu }}</td>
                    <td>{{ $c->titre }}</td>
                    <td>{{ \Illuminate\Support\Str::limit(strip_tags($c->texte), 80) }}</td>
                    <td>{{ $c->date_creation }}</td>
                    <td>{{ $c->region->nom_region ?? '-' }}</td>
                    <td>{{ $c->langue->nom_langue ?? '-' }}</td>
                    <td>{{ $c->typecontenu->nom_contenu ?? '-' }}</td>
                    <td>{{ $c->auteur->nom ?? '-' }} {{ $c->auteur->prenom ?? '' }}</td>
                    <td class="actions">
                        <form method="POST" action="{{ url('/moderateur/contenu/'.$c->id_contenu.'/approve') }}" style="display:inline">
                            @csrf
                            <button class="btn-icon btn-approve" title="Accepter"><i class="fas fa-check"></i></button>
                        </form>

                        <button type="button" class="btn-icon btn-view" title="Voir"
                            data-id="{{ $c->id_contenu }}"
                            data-titre="{{ e($c->titre) }}"
                            data-texte="{{ e($c->texte) }}"
                            data-region="{{ $c->region->nom_region ?? '' }}"
                            data-langue="{{ $c->langue->nom_langue ?? '' }}"
                            data-type="{{ $c->typecontenu->nom_contenu ?? '' }}"
                            data-auteur="{{ $c->auteur->nom ?? '' }} {{ $c->auteur->prenom ?? '' }}"
                            data-date="{{ $c->date_creation }}"
                            data-image="{{ $c->image_url ?? '' }}"
                        ><i class="fas fa-eye"></i></button>

                        <form method="POST" action="{{ url('/moderateur/contenu/'.$c->id_contenu) }}" style="display:inline" onsubmit="return confirm('Supprimer ce contenu ?');">
                            @csrf @method('DELETE')
                            <button class="btn-icon btn-delete" title="Supprimer"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9">Aucun contenu en attente.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Détail -->
    <div id="contenuModal" class="modal-overlay" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999;">
        <div class="modal-content" style="max-width:900px; margin:60px auto; background:#fff; border-radius:8px; padding:18px; position:relative;">
            <button id="closeModal" style="position:absolute; top:10px; right:16px; background:none; border:none; font-size:22px; cursor:pointer;">*</button>
            <h2 id="modalTitre" style="margin-top:6px;"></h2>
            <div style="display:flex; gap:20px; margin-top:12px;">
                <div style="flex:2;">
                    <div id="modalImageWrapper" style="margin-bottom:12px;">
                        <img id="modalImage" src="" alt="" style="width:100%; max-height:360px; object-fit:cover; border-radius:6px; display:none;">
                    </div>
                    <div id="modalTexte" style="white-space:pre-wrap; line-height:1.6; color:#333;"></div>
                </div>
                <div style="flex:1;">
                    <ul style="list-style:none; padding:0;">
                        <li><strong>Région:</strong> <span id="modalRegion"></span></li>
                        <li><strong>Langue:</strong> <span id="modalLangue"></span></li>
                        <li><strong>Type:</strong> <span id="modalType"></span></li>
                        <li><strong>Auteur:</strong> <span id="modalAuteur"></span></li>
                        <li><strong>Date:</strong> <span id="modalDate"></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            document.querySelectorAll('.btn-view').forEach(function(btn){
                btn.addEventListener('click', function(){
                    var titre = this.getAttribute('data-titre') || '';
                    var texte = this.getAttribute('data-texte') || '';
                    var region = this.getAttribute('data-region') || '';
                    var langue = this.getAttribute('data-langue') || '';
                    var type = this.getAttribute('data-type') || '';
                    var auteur = this.getAttribute('data-auteur') || '';
                    var date = this.getAttribute('data-date') || '';
                    var image = this.getAttribute('data-image') || '';

                    document.getElementById('modalTitre').innerText = titre;
                    document.getElementById('modalTexte').innerText = texte;
                    document.getElementById('modalRegion').innerText = region;
                    document.getElementById('modalLangue').innerText = langue;
                    document.getElementById('modalType').innerText = type;
                    document.getElementById('modalAuteur').innerText = auteur;
                    document.getElementById('modalDate').innerText = date;

                    var imgEl = document.getElementById('modalImage');
                    if(image){ imgEl.src = image; imgEl.style.display = 'block'; } else { imgEl.style.display = 'none'; }

                    document.getElementById('contenuModal').style.display = 'block';
                });
            });

            document.getElementById('closeModal').addEventListener('click', function(){
                document.getElementById('contenuModal').style.display = 'none';
            });
            document.getElementById('contenuModal').addEventListener('click', function(e){
                if(e.target === this) this.style.display = 'none';
            });
        });
    </script>
</section>
@endsection
