@extends('dashboard.layout')

@section('content')
<section id="moderateurs" class="content-section active">
    <div class="section-header">
        <h1>Gestion des Modérateurs</h1>
        <button id="openModeratorModal" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un modérateur
        </button>
    </div>
    <div class="section-search">
        <div class="search-filter">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Rechercher un modérateur...">
        </div>
    </div>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Date d'ajout</th>
                   
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($moderators ?? [] as $moderator)
                <tr>
                    <td>#M{{ str_pad($moderator->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ ($moderator->nom ?? '') . ' ' . ($moderator->prenom ?? '') }}</td>
                    <td>{{ $moderator->email }}</td>
                    <td><span class="badge badge-moderator">Modérateur</span></td>
                    <td>{{ optional($moderator->created_at)->format('d/m/Y') ?? ($moderator->date_inscription ?? '—') }}</td>

                    <td class="actions">
                        <button type="button" class="btn-icon btn-view"
                            data-id="{{ $moderator->id ?? '' }}"
                            data-nom="{{ e($moderator->nom ?? '') }}"
                            data-prenom="{{ e($moderator->prenom ?? '') }}"
                            data-email="{{ e($moderator->email ?? '') }}"
                            data-date_inscription="{{ e($moderator->date_inscription ?? '') }}"
                            data-date_naissance="{{ e($moderator->date_naissance ?? '') }}"
                            data-statut="{{ e($moderator->statut ?? '') }}"
                            data-photo="{{ e($moderator->photo ?? '') }}"
                            data-id_langue="{{ e($moderator->id_langue ?? '') }}"
                        ><i class="fas fa-eye"></i></button>
                        <button type="button" class="btn-icon btn-edit"
                            data-id="{{ $moderator->id ?? '' }}"
                            data-nom="{{ e($moderator->nom ?? '') }}"
                            data-prenom="{{ e($moderator->prenom ?? '') }}"
                            data-email="{{ e($moderator->email ?? '') }}"
                            data-date_inscription="{{ e($moderator->date_inscription ?? '') }}"
                            data-date_naissance="{{ e($moderator->date_naissance ?? '') }}"
                            data-statut="{{ e($moderator->statut ?? '') }}"
                            data-photo="{{ e($moderator->photo ?? '') }}"
                            data-id_langue="{{ e($moderator->id_langue ?? '') }}"
                        ><i class="fas fa-edit"></i></button>
                        <form action="{{ url('/admin/utilisateurs/' . ($moderator->id ?? '')) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon btn-delete" onclick="return confirm('Supprimer ce modérateur ?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Modal Modérateur -->
    <style>
        #moderatorModal.modal-overlay{ display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1200; align-items:center; justify-content:center; }
        #moderatorModal .modal-content{ background:#fff; padding:20px; max-width:720px; width:95%; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.2); }
        #moderatorModal .form-control{ width:100%; padding:8px; border-radius:8px; border:1px solid #ddd; }
    </style>

    <div id="moderatorModal" class="modal-overlay">
        <div class="modal-content">
            <button id="closeModeratorModal" style="position:absolute; right:12px; top:8px; border:none; background:transparent; font-size:18px;">&times;</button>
            <h3>Ajouter un modérateur</h3>
            <form id="moderatorForm" method="POST" action="{{ url('/admin/utilisateurs') }}">
                @csrf
                <input type="hidden" name="_method" id="moderator_method" value="">
                <input type="hidden" name="id_role" value="3">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label>Nom</label>
                        <input id="mod_nom" name="nom" class="form-control" required />
                    </div>
                    <div>
                        <label>Prénom</label>
                        <input id="mod_prenom" name="prenom" class="form-control" required />
                    </div>
                </div>
                <div style="margin-top:8px; display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label>Email</label>
                        <input id="mod_email" name="email" type="email" class="form-control" required />
                    </div>
                    <div>
                        <label>Mot de passe</label>
                        <input id="mod_password" name="mot_de_passe" type="password" class="form-control" />
                    </div>
                </div>
                <div style="margin-top:8px; display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label>Date inscription</label>
                        <input id="mod_date_inscription" name="date_inscription" type="date" class="form-control" />
                    </div>
                    <div>
                        <label>Date naissance</label>
                        <input id="mod_date_naissance" name="date_naissance" type="date" class="form-control" />
                    </div>
                </div>
                <div style="margin-top:8px;">
                    <label>Langue</label>
                    <select id="mod_id_langue" name="id_langue" class="form-control">
                        <option value="">--</option>
                        @foreach($langues ?? [] as $lang)
                            <option value="{{ $lang->id_langue }}">{{ $lang->nom_langue }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="text-align:right; margin-top:12px;">
                    <button type="button" id="cancelModerator" class="btn">Annuler</button>
                    <button type="submit" id="moderatorSubmit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function(){
            var openBtn = document.getElementById('openModeratorModal');
            var modal = document.getElementById('moderatorModal');
            var closeBtn = document.getElementById('closeModeratorModal');
            var cancelBtn = document.getElementById('cancelModerator');
            var form = document.getElementById('moderatorForm');
            var methodInput = document.getElementById('moderator_method');
            var submitBtn = document.getElementById('moderatorSubmit');

            function openModal(){ modal.style.display = 'flex'; }
            function closeModal(){ modal.style.display = 'none'; }
            function resetAdd(){
                form.action = "{{ url('/admin/utilisateurs') }}"; methodInput.value=''; submitBtn.textContent='Enregistrer'; document.getElementById('mod_nom').value=''; document.getElementById('mod_prenom').value=''; document.getElementById('mod_email').value=''; document.getElementById('mod_password').value=''; document.getElementById('mod_date_inscription').value=''; document.getElementById('mod_date_naissance').value=''; document.getElementById('mod_id_langue').value='';
            }

            if(openBtn){ openBtn.addEventListener('click', function(){ resetAdd(); openModal(); }); }
            if(closeBtn){ closeBtn.addEventListener('click', closeModal); }
            if(cancelBtn){ cancelBtn.addEventListener('click', closeModal); }
            if(modal){ modal.addEventListener('click', function(e){ if(e.target===modal) closeModal(); }); }

            document.addEventListener('click', function(e){
                var viewBtn = e.target.closest('.btn-view');
                var editBtn = e.target.closest('.btn-edit');
                if(!viewBtn && !editBtn) return;
                e.preventDefault();
                var btn = viewBtn || editBtn;
                var id = btn.getAttribute('data-id');
                var nom = btn.getAttribute('data-nom') || '';
                var prenom = btn.getAttribute('data-prenom') || '';
                var email = btn.getAttribute('data-email') || '';
                var date_inscription = btn.getAttribute('data-date_inscription') || '';
                var date_naissance = btn.getAttribute('data-date_naissance') || '';
                var id_langue = btn.getAttribute('data-id_langue') || '';

                if(viewBtn){ form.action='#'; methodInput.value=''; submitBtn.style.display='none'; document.getElementById('mod_nom').value=nom; document.getElementById('mod_prenom').value=prenom; document.getElementById('mod_email').value=email; document.getElementById('mod_date_inscription').value=date_inscription; document.getElementById('mod_date_naissance').value=date_naissance; document.getElementById('mod_id_langue').value=id_langue; openModal(); return; }

                if(editBtn){ form.action = '{{ url('/admin/utilisateurs') }}/' + id; methodInput.value='PUT'; submitBtn.style.display='inline-block'; submitBtn.textContent='Modifier'; document.getElementById('mod_nom').value=nom; document.getElementById('mod_prenom').value=prenom; document.getElementById('mod_email').value=email; document.getElementById('mod_date_inscription').value=date_inscription; document.getElementById('mod_date_naissance').value=date_naissance; document.getElementById('mod_id_langue').value=id_langue; openModal(); return; }
            });
        })();
    </script>

</section>
@endsection