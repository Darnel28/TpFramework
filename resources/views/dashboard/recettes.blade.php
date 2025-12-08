@extends('dashboard.layout')

@section('content')
<section id="recettes" class="content-section active">

    <div class="section-header">
        <h1>Gestion des Recettes</h1>
        <button id="openRecetteModal" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter une recette
        </button>
    </div>
  

    

    <div class="section-search">
        <div class="search-filter">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Rechercher une recette..." id="searchRecette">
        </div>
    </div>

    <!-- TABLEAU DES RECETTES -->
    <div class="recent-activity" style="margin-top: 30px;">
        <h2>Liste des Recettes</h2>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Aperçu</th>
                        <th>Auteur</th>
                        <th>Modérateur</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recettes as $r)
                    <tr>
                        <td>#{{ $r->id_contenu }}</td>
                        <td>{{ $r->titre }}</td>
                        <td>{{ \Illuminate\Support\Str::limit(strip_tags($r->texte), 120) }}</td>
                        <td>@if($r->auteur) {{ $r->auteur->nom }} {{ $r->auteur->prenom }} @else - @endif</td>
                        <td>@if($r->moderateur) {{ $r->moderateur->nom }} {{ $r->moderateur->prenom }} @else - @endif</td>
                        <td>
                            @if(in_array(strtolower($r->statut), ['publie','publié']))
                                <span class="badge bg-success">Publié</span>
                            @elseif(strtolower($r->statut) === 'brouillon')
                                <span class="badge bg-warning">Brouillon</span>
                            @else
                                <span class="badge bg-secondary">{{ $r->statut }}</span>
                            @endif
                        </td>
                        <td class="actions">
                            <button type="button" class="btn-icon btn-view"
                                data-id="{{ $r->id_contenu }}"
                                data-titre="{{ e($r->titre) }}"
                                data-texte="{{ e($r->texte) }}"
                                data-image="{{ $r->image ?? '' }}"
                                data-video="{{ $r->video ?? '' }}"
                            ><i class="fas fa-eye"></i></button>

                            <button type="button" class="btn-icon btn-edit"
                                data-id="{{ $r->id_contenu }}"
                                data-titre="{{ e($r->titre) }}"
                                data-texte="{{ e($r->texte) }}"
                                data-image="{{ $r->image ?? '' }}"
                                data-video="{{ $r->video ?? '' }}"
                            ><i class="fas fa-edit"></i></button>

                            <form action="{{ url('/admin/contenu/'.$r->id_contenu) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn-icon btn-delete" onclick="return confirm('Supprimer cette recette ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">Aucune recette trouvée.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    

    <!-- MODAL AJOUT / EDIT / VIEW -->
    <div id="recetteModal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <h2 id="recetteModalTitle">Ajouter une recette</h2>
            <button id="closeRecetteModal" style="position:absolute; top:10px; right:10px; border:none; background:none; font-size:22px; cursor:pointer;">×</button>

            <form id="recetteForm" method="POST" action="{{ url('/admin/recettes') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="methodRecette">

                <div class="mb-3">
                    <label>Titre</label>
                    <input type="text" id="titre" name="titre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Texte</label>
                    <textarea id="texte" name="texte" class="form-control" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label>Région</label>
                    <select name="id_region" class="form-control" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($regions as $r)
                            <option value="{{ $r->id_region }}">{{ $r->nom_region }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Langue</label>
                    <select name="id_langue" class="form-control" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($langues as $l)
                            <option value="{{ $l->id_langue }}">{{ $l->nom_langue }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Modérateur</label>
                    <select name="id_moderateur" class="form-control">
                        <option value="">-- Aucun --</option>
                        @foreach($moderateurs as $m)
                            <option value="{{ $m->id_utilisateur }}">{{ $m->nom }} {{ $m->prenom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Auteur</label>
                    <select name="id_auteur" class="form-control" required>
                        @foreach($auteurs as $a)
                            <option value="{{ $a->id_utilisateur }}">{{ $a->nom }} {{ $a->prenom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control">
                    <img id="previewImage" style="display:none; max-width:100%; margin-top:8px; border-radius:8px;">
                    <a id="downloadRecetteImage" href="#" download style="display:none; margin-left:8px;">Télécharger</a>
                </div>

                <div class="mb-3">
                    <label>Vidéo (facultatif)</label>
                    <input type="file" name="video" class="form-control" accept="video/*">
                    <video id="previewVideo" controls style="display:none; max-width:100%; margin-top:8px;"></video>
                    <a id="downloadRecetteVideo" href="#" download style="display:none; margin-left:8px;">Télécharger la vidéo</a>
                </div>

                <div style="margin-top:20px; text-align:right;">
                    <button type="button" id="cancelRecette" class="btn btn-secondary">Annuler</button>
                    <button type="submit" id="recetteSubmitBtn" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Modal */
        #recetteModal.modal-overlay {
            display:flex;
            position:fixed;
            inset:0;
            background:rgba(0,0,0,0.5);
            z-index:1200;
            align-items:center;
            justify-content:center;
        }
        #recetteModal .modal-content {
            background:#fff;
            padding:22px;
            width:92%;
            max-width:680px;
            border-radius:12px;
            position:relative;
        }
        #recetteModal .form-control {
            width:100%;
            padding:10px 12px;
            border:1px solid #dcdcdc;
            border-radius:8px;
        }
        #recetteModal label { font-weight:600; margin-bottom:6px; display:block; }
        #recetteModal .btn { padding:8px 14px; border-radius:8px; }
        #recetteModal .btn-primary { background:#2d6cdf; color:white; border:none; }
        #recetteModal img, #recetteModal video { max-width:100%; border-radius:8px; margin-top:8px; }
    </style>

    <script>
    (function(){
        const openBtn     = document.getElementById("openRecetteModal");
        const modal       = document.getElementById("recetteModal");
        const closeBtn    = document.getElementById("closeRecetteModal");
        const cancelBtn   = document.getElementById("cancelRecette");
        const form        = document.getElementById("recetteForm");
        const method      = document.getElementById("methodRecette");
        const title       = document.getElementById("recetteModalTitle");
        const submitBtn   = document.getElementById("recetteSubmitBtn");

        const titre       = document.getElementById("titre");
        const texte       = document.getElementById("texte");
        const previewImg  = document.getElementById("previewImage");
        const previewVideo= document.getElementById("previewVideo");
        const downloadImg = document.getElementById("downloadRecetteImage");
        const downloadVid = document.getElementById("downloadRecetteVideo");

        function openModal(){ modal.style.display = "flex"; }
        function closeModal(){ modal.style.display = "none"; }

        function resetForm(){
            form.action = "{{ url('/admin/recettes') }}";
            method.value = "";
            title.textContent = "Ajouter une recette";
            submitBtn.textContent = "Enregistrer";

            titre.value = "";
            texte.value = "";
            previewImg.style.display = "none";
            previewImg.src = "";
            previewVideo.style.display = "none";
            previewVideo.src = "";
            downloadImg.style.display = "none";
            downloadVid.style.display = "none";

            titre.disabled = false;
            texte.disabled = false;
            submitBtn.style.display = 'inline-block';
        }

        openBtn.addEventListener("click", function(){
            resetForm();
            openModal();
        });

        closeBtn.addEventListener("click", closeModal);
        cancelBtn.addEventListener("click", closeModal);
        modal.addEventListener("click", function(e){ if(e.target===modal) closeModal(); });

        document.addEventListener('click', function(e){
            const viewBtn = e.target.closest('.btn-view');
            const editBtn = e.target.closest('.btn-edit');
            if(!viewBtn && !editBtn) return;

            const btn = viewBtn || editBtn;
            const tr = btn.closest('tr');
            const id = btn.dataset.id;
            const titreVal = btn.dataset.titre;
            const texteVal = btn.dataset.texte;
            const img = btn.dataset.image;
            const video = btn.dataset.video;

            titre.value = titreVal;
            texte.value = texteVal;

            if(img){ previewImg.src = img; previewImg.style.display='block'; downloadImg.href=img; downloadImg.style.display='inline-block'; }
            else { previewImg.style.display='none'; downloadImg.style.display='none'; }

            if(video){ previewVideo.src=video; previewVideo.style.display='block'; downloadVid.href=video; downloadVid.style.display='inline-block'; }
            else { previewVideo.style.display='none'; previewVideo.src=''; downloadVid.style.display='none'; }

            if(editBtn){
                form.action = "{{ url('/admin/recettes') }}/" + id;
                method.value = "PUT";
                title.textContent = "Modifier la recette";
                submitBtn.textContent = "Mettre à jour";
                titre.disabled=false;
                texte.disabled=false;
                submitBtn.style.display='inline-block';
            } else {
                form.action = "#";
                method.value="";
                title.textContent="Aperçu de la recette";
                submitBtn.style.display='none';
                titre.disabled=true;
                texte.disabled=true;
            }

            openModal();
        });

    })();
    </script>
</section>
@endsection
