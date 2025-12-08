@extends('dashboard.layout')

@section('content')
<section id="histoires" class="content-section">
    <div class="section-header">
        <h1>Gestion des Histoires</h1>
        <button type="button" id="openHistoireModal" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter une histoire
        </button>
    </div>

    <div class="section-search">
        <div class="search-filter">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Rechercher une histoire...">
        </div>
    </div>
    <div class="recent-activity" style="margin-top: 30px;">
        <h2>Liste des Recettes</h2>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Extrait</th>
                    <th>Auteur</th>
                    <th>Modérateur</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($histoires as $h)
                <tr>
                    <td>#{{ $h->id_contenu }}</td>
                    <td>{{ $h->titre }}</td>
                    <td>{{ \Illuminate\Support\Str::limit(strip_tags($h->texte), 120) }}</td>
                    <td>{{ $h->auteur->nom ?? '-' }} {{ $h->auteur->prenom ?? '' }}</td>
                    <td>{{ $h->moderateur->nom ?? '-' }} {{ $h->moderateur->prenom ?? '' }}</td>
                    <td>{{ $h->statut }}</td>
                    <td class="actions">
                        <button type="button" class="btn-icon btn-view"
                            data-id="{{ $h->id_contenu }}"
                            data-titre="{{ e($h->titre) }}"
                            data-texte="{{ e($h->texte) }}"
                            data-region="{{ $h->id_region ?? '' }}"
                            data-langue="{{ $h->id_langue ?? '' }}"
                            data-auteur="{{ $h->id_auteur ?? '' }}"
                            data-moderateur="{{ $h->id_moderateur ?? '' }}"
                            data-image="{{ $h->image ?? '' }}"
                            data-video="{{ $h->video ?? '' }}"
                        ><i class="fas fa-eye"></i></button>

                        <button type="button" class="btn-icon btn-edit"
                            data-id="{{ $h->id_contenu }}"
                            data-titre="{{ e($h->titre) }}"
                            data-texte="{{ e($h->texte) }}"
                            data-region="{{ $h->id_region ?? '' }}"
                            data-langue="{{ $h->id_langue ?? '' }}"
                            data-auteur="{{ $h->id_auteur ?? '' }}"
                            data-moderateur="{{ $h->id_moderateur ?? '' }}"
                            data-image="{{ $h->image ?? '' }}"
                            data-video="{{ $h->video ?? '' }}"
                        ><i class="fas fa-edit"></i></button>

                        <form action="{{ url('/admin/contenu/'.$h->id_contenu) }}" method="POST" style="display:inline" onsubmit="return confirm('Supprimer cette histoire ?');">
                            @csrf @method('DELETE')
                            <button class="btn-icon btn-delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7">Aucune histoire trouvée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

    <!-- Modal identique à recette -->
    <div id="histoireModal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <h2 id="histoireModalTitle">Ajouter une histoire</h2>
            <button id="closeHistoireModal" style="position:absolute; top:10px; right:10px; border:none; background:none; font-size:22px; cursor:pointer;">×</button>

            <form id="histoireForm" method="POST" action="{{ url('/admin/histoires') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="methodHistoire">
                <input type="hidden" name="id_type_contenu" value="3">
                <input type="hidden" name="parent_id" value="0">
                <input type="hidden" name="statut" value="publié">

                <div class="mb-3">
                    <label>Titre</label>
                    <input type="text" id="titreHistoire" name="titre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Texte</label>
                    <textarea id="texteHistoire" name="texte" class="form-control" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label>Région</label>
                    <select id="regionHistoire" name="id_region" class="form-control" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($regions as $r)
                            <option value="{{ $r->id_region }}">{{ $r->nom_region }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Langue</label>
                    <select id="langueHistoire" name="id_langue" class="form-control" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($langues as $l)
                            <option value="{{ $l->id_langue }}">{{ $l->nom_langue }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Modérateur</label>
                    <select id="moderateurHistoire" name="id_moderateur" class="form-control">
                        <option value="">-- Aucun --</option>
                        @foreach($moderateurs as $m)
                            <option value="{{ $m->id_utilisateur }}">{{ $m->nom }} {{ $m->prenom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Auteur</label>
                    <select id="auteurHistoire" name="id_auteur" class="form-control" required>
                        @foreach($auteurs as $a)
                            <option value="{{ $a->id_utilisateur }}">{{ $a->nom }} {{ $a->prenom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control">
                    <img id="previewImageHistoire" style="display:none;">
                    <a id="downloadImageHistoire" href="#" download style="display:none; margin-left:8px;">Télécharger</a>
                </div>

                <div class="mb-3">
                    <label>Vidéo (facultatif)</label>
                    <input type="file" name="video" class="form-control" accept="video/*">
                    <video id="previewVideoHistoire" controls style="display:none; max-width:100%; margin-top:8px;"></video>
                    <a id="downloadVideoHistoire" href="#" download style="display:none; margin-left:8px;">Télécharger la vidéo</a>
                </div>

                <div style="margin-top:20px; text-align:right;">
                    <button type="button" id="cancelHistoire" class="btn btn-secondary">Annuler</button>
                    <button type="submit" id="histoireSubmitBtn" class="btn btn-primary">Enregistrer</button>
                </div>

            </form>
        </div>
    </div>

    <style>
        #histoireModal.modal-overlay {position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1200; display:flex; align-items:center; justify-content:center;}
        #histoireModal .modal-content {background:#fff; padding:22px; max-width:680px; width:92%; border-radius:12px; position:relative;}
        #histoireModal .form-control {width:100%; padding:8px; border:1px solid #ddd; border-radius:8px;}
        #histoireModal .btn {padding:8px 14px; border-radius:8px;}
        #histoireModal .btn-primary {background:#2d6cdf; color:#fff; border:none;}
    </style>

    <script>
        (function(){
            const modal = document.getElementById("histoireModal");
            const openBtn = document.getElementById("openHistoireModal");
            const closeBtn = document.getElementById("closeHistoireModal");
            const cancelBtn = document.getElementById("cancelHistoire");
            const form = document.getElementById("histoireForm");
            const methodInput = document.getElementById("methodHistoire");
            const titleEl = document.getElementById("histoireModalTitle");

            openBtn.addEventListener('click', () => {
                form.reset();
                methodInput.value='';
                titleEl.textContent='Ajouter une histoire';
                document.getElementById('histoireSubmitBtn').style.display='inline-block';
                modal.style.display='flex';
            });

            closeBtn.addEventListener('click', ()=> modal.style.display='none');
            cancelBtn.addEventListener('click', ()=> modal.style.display='none');
            modal.addEventListener('click', e=> {if(e.target===modal) modal.style.display='none';});

            document.addEventListener('click', function(e){
                const viewBtn = e.target.closest('.btn-view');
                const editBtn = e.target.closest('.btn-edit');
                if(!viewBtn && !editBtn) return;
                const btn = viewBtn || editBtn;

                const id = btn.getAttribute('data-id');
                const titre = btn.getAttribute('data-titre') || '';
                const texte = btn.getAttribute('data-texte') || '';
                const region = btn.getAttribute('data-region') || '';
                const langue = btn.getAttribute('data-langue') || '';
                const auteur = btn.getAttribute('data-auteur') || '';
                const moderateur = btn.getAttribute('data-moderateur') || '';
                const image = btn.getAttribute('data-image') || '';
                const video = btn.getAttribute('data-video') || '';

                document.getElementById('titreHistoire').value=titre;
                document.getElementById('texteHistoire').value=texte;
                document.getElementById('regionHistoire').value=region;
                document.getElementById('langueHistoire').value=langue;
                document.getElementById('auteurHistoire').value=auteur;
                document.getElementById('moderateurHistoire').value=moderateur;

                if(image){ document.getElementById('previewImageHistoire').src=image; document.getElementById('previewImageHistoire').style.display='block'; }
                else { document.getElementById('previewImageHistoire').style.display='none'; }
                if(video){ document.getElementById('previewVideoHistoire').src=video; document.getElementById('previewVideoHistoire').style.display='block'; }
                else { document.getElementById('previewVideoHistoire').style.display='none'; }

                if(viewBtn){
                    titleEl.textContent='Détails de l\'histoire';
                    document.getElementById('histoireSubmitBtn').style.display='none';
                    document.getElementById('titreHistoire').disabled=true;
                    document.getElementById('texteHistoire').disabled=true;
                }

                if(editBtn){
                    titleEl.textContent='Modifier l\'histoire';
                    form.action="{{ url('/admin/contenu') }}/"+id;
                    methodInput.value='PUT';
                    document.getElementById('histoireSubmitBtn').style.display='inline-block';
                    document.getElementById('titreHistoire').disabled=false;
                    document.getElementById('texteHistoire').disabled=false;
                }

                modal.style.display='flex';
            });
        })();
    </script>

</section>
@endsection
