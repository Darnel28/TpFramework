@extends('dashboard.layout')

@section('content')
<section id="utilisateurs" class="content-section active">
    <div class="section-header">
        <h1>Gestion des Utilisateurs</h1>
        <button id="openUserModal" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un utilisateur
        </button>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="section-search">
        <div class="search-filter">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Rechercher un utilisateur..." id="searchInput">
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th><th>Nom</th><th>Email</th><th>Rôle</th>
                    <th>Date d'inscription</th><th>Statut</th><th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTable">
                @foreach($users ?? [] as $user)
                <tr>
                    <td>#{{ str_pad($user->id,3,'0',STR_PAD_LEFT) }}</td>
                    <td>{{ $user->nom }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->id_role == 2)<span class="badge badge-admin">Admin</span>
                        @elseif($user->id_role == 3)<span class="badge badge-moderator">Modérateur</span>
                        @else<span class="badge badge-user">Utilisateur</span>@endif
                    </td>
                    <td>{{ $user->date_inscription }}</td>
                    <td>
                        @if($user->actif ?? true)
                            <span class="badge badge-success">Actif</span>
                        @else
                            <span class="badge badge-warning">Inactif</span>
                        @endif
                    </td>
                    <td class="actions">
                        <button class="btn-icon btn-view" 
                            data-id="{{ $user->id }}" data-nom="{{ $user->nom }}"
                            data-prenom="{{ $user->prenom }}" data-email="{{ $user->email }}"
                            data-sexe="{{ $user->sexe }}" data-date_inscription="{{ $user->date_inscription }}"
                            data-date_naissance="{{ $user->date_naissance }}" data-statut="{{ $user->statut }}"
                            data-photo="{{ $user->photo }}" data-id_role="{{ $user->id_role }}"
                            data-id_langue="{{ $user->id_langue }}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-icon btn-edit"
                            data-id="{{ $user->id }}" data-nom="{{ $user->nom }}"
                            data-prenom="{{ $user->prenom }}" data-email="{{ $user->email }}"
                            data-sexe="{{ $user->sexe }}" data-date_inscription="{{ $user->date_inscription }}"
                            data-date_naissance="{{ $user->date_naissance }}" data-statut="{{ $user->statut }}"
                            data-photo="{{ $user->photo }}" data-id_role="{{ $user->id_role }}"
                            data-id_langue="{{ $user->id_langue }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <!-- @if(!empty($user->photo))
                       <a href="{{ asset($user->photo) }}" class="btn-icon btn-download" download>

                        </a>
                        @endif -->
                        <form action="{{ url('/admin/utilisateurs/'.$user->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon btn-delete" onclick="return confirm('Supprimer cet utilisateur ?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal Utilisateur --}}
    <div id="userModal" class="modal-overlay">
        <div class="modal-content">
            <button id="closeUserModal" class="close-btn">&times;</button>
            <h3 id="modalTitle">Ajouter un utilisateur</h3>
            <form id="userForm" method="POST" action="{{ url('/admin/utilisateurs') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="user_method" value="">
                <div class="grid-2">
                    <div><label for="nom">Nom</label><input id="nom" name="nom" class="form-control" required></div>
                    <div><label for="prenom">Prénom</label><input id="prenom" name="prenom" class="form-control" required></div>
                </div>
                <div class="grid-2">
                    <div><label for="email">Email</label><input id="email" name="email" type="email" class="form-control" required></div>
                    <div><label for="mot_de_passe">Mot de passe</label><input id="mot_de_passe" name="mot_de_passe" type="password" class="form-control"></div>
                </div>
                <div class="grid-2">
                    <div><label for="sexe">Sexe</label><input id="sexe" name="sexe" class="form-control"></div>
                    <div><label for="date_naissance">Date de naissance</label><input id="date_naissance" name="date_naissance" type="date" class="form-control"></div>
                </div>
                <div class="grid-2">
                    <div><label for="date_inscription">Date d'inscription</label><input id="date_inscription" name="date_inscription" type="date" class="form-control"></div>
                    <div><label for="statut">Statut</label><input id="statut" name="statut" class="form-control"></div>
                </div>
                <div class="grid-2">
                    <div>
                        <label for="id_role">Rôle</label>
                        <select id="id_role" name="id_role" class="form-control">
                            <option value="1">Lecteur</option>
                            <option value="2">Admin</option>
                            <option value="3">Modérateur</option>
                        </select>
                    </div>
                    <div>
                        <label for="id_langue">Langue</label>
                        <select id="id_langue" name="id_langue" class="form-control">
                            <option value="">--</option>
                            @foreach($langues ?? [] as $lang)
                                <option value="{{ $lang->id_langue }}">{{ $lang->nom_langue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label for="photo">Photo (fichier)</label>
                    <input id="photo" name="photo" type="file" accept="image/*" class="form-control">
                    <img id="photoPreview" src="" alt="Aperçu" style="display:none; max-width:120px; margin-top:8px; border-radius:6px;"/>
                    <!-- <a id="photoDownload" href="#" download style="display:none; margin-left:8px;">Télécharger</a> -->
                </div>
                <div class="modal-actions">
                    <button type="button" id="cancelUser" class="btn btn-secondary">Annuler</button>
                    <button type="submit" id="userSubmit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Styles inclus dans le fichier --}}
    <style>
        /* Modal */
        .modal-overlay {
            position: fixed; top:0; left:0; width:100%; height:100%;
            background: rgba(0,0,0,0.5); display:none;
            justify-content:center; align-items:center; z-index:1000;
        }
        .modal-content {
            background:#fff; padding:20px; border-radius:8px;
            width:90%; max-width:600px; position:relative;
            box-shadow:0 5px 15px rgba(0,0,0,0.3);
        }
        .modal-content .form-control {
            width:100%; padding:8px; margin-bottom:12px;
            border-radius:4px; border:1px solid #ccc;
        }
        .grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:8px; }
        .modal-actions { text-align:right; margin-top:12px; }
        .close-btn { position:absolute; top:10px; right:12px; border:none; background:transparent; font-size:18px; cursor:pointer; }
        .btn-primary { background:#4361ee; color:#fff; border:none; padding:8px 16px; border-radius:4px; }
        .btn-secondary { background:#6c757d; color:#fff; border:none; padding:8px 16px; border-radius:4px; }
    </style>

    {{-- JS Modal --}}
    <script>
    (function(){
        var openBtn = document.getElementById('openUserModal');
        var modal = document.getElementById('userModal');
        var closeBtn = document.getElementById('closeUserModal');
        var cancelBtn = document.getElementById('cancelUser');
        var form = document.getElementById('userForm');
        var methodInput = document.getElementById('user_method');
        var submitBtn = document.getElementById('userSubmit');
        var modalTitle = document.getElementById('modalTitle');

        function openModal(){ modal.style.display='flex'; modal.style.flexDirection='column'; }
        function closeModal(){ modal.style.display='none'; }

        openBtn?.addEventListener('click', function(){ resetAdd(); openModal(); });
        closeBtn?.addEventListener('click', closeModal);
        cancelBtn?.addEventListener('click', closeModal);
        modal?.addEventListener('click', e => { if(e.target===modal) closeModal(); });

        function resetAdd(){
            form.action = "{{ url('/admin/utilisateurs') }}";
            methodInput.value='';
            submitBtn.textContent='Enregistrer';
            modalTitle.textContent='Ajouter un utilisateur';
            ['nom','prenom','email','mot_de_passe','sexe','date_inscription','date_naissance','statut','photo','id_role','id_langue'].forEach(id=>{
                if(document.getElementById(id)) document.getElementById(id).value = id==='id_role'?'1':'';
            });
            // reset image preview & download link
            var preview = document.getElementById('photoPreview');
            var download = document.getElementById('photoDownload');
            if(preview){ preview.style.display='none'; preview.src=''; }
            if(download){ download.style.display='none'; download.href='#'; }
            document.getElementById('nom').disabled=false;
            submitBtn.style.display='inline-block';
        }

        document.addEventListener('click', function(e){
            var viewBtn = e.target.closest('.btn-view');
            var editBtn = e.target.closest('.btn-edit');
            if(!viewBtn && !editBtn) return;
            e.preventDefault();
            var btn = viewBtn || editBtn;

            var data = {};
            ['id','nom','prenom','email','mot_de_passe','sexe','date_inscription','date_naissance','statut','photo','id_role','id_langue'].forEach(k=>{
                data[k] = btn.dataset[k] || '';
            });

            if(viewBtn){
                form.action='#';
                methodInput.value='';
                submitBtn.style.display='none';
                modalTitle.textContent='Détails utilisateur';
                document.getElementById('nom').disabled=true;
            } else {
                form.action='{{ url('/admin/utilisateurs') }}/'+data.id;
                methodInput.value='PUT';
                submitBtn.style.display='inline-block';
                submitBtn.textContent='Modifier';
                modalTitle.textContent='Modifier utilisateur';
                document.getElementById('nom').disabled=false;
            }

            for(let key in data){
                if(document.getElementById(key) && key !== 'photo') document.getElementById(key).value=data[key];
            }
            // set preview for existing photo link and download
            if(data.photo){
                var preview = document.getElementById('photoPreview');
                var download = document.getElementById('photoDownload');
                if(preview){ preview.src = data.photo; preview.style.display='block'; }
                if(download){ download.href = "{{ asset('') }}" + data.photo; download.style.display='inline-block'; }
            } else {
                var preview = document.getElementById('photoPreview'); if(preview) preview.style.display='none';
                var download = document.getElementById('photoDownload'); if(download) download.style.display='none';
            }

            openModal();
        });
        // Show preview when selecting a file
        document.getElementById('photo')?.addEventListener('change', function(e){
            var file = e.target.files[0];
            var preview = document.getElementById('photoPreview');
            if(!preview) return;
            if(file){
                var reader = new FileReader();
                reader.onload = function(ev){ preview.src = ev.target.result; preview.style.display='block'; }
                reader.readAsDataURL(file);
                // when a file is selected, hide the download link since this is a local image
                if(document.getElementById('photoDownload')) { document.getElementById('photoDownload').style.display='none'; }
            } else { preview.style.display='none'; preview.src=''; }
        });
    })();
    </script>

</section>
@endsection
