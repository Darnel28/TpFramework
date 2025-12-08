@extends('dashboard.layout')

@section('content')
<section id="langues" class="content-section active">
    <div class="section-header">
        <h1>Gestion des Langues</h1>
        <button id="openLangueModal" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter une langue
        </button>
    </div>
      <div class="section-search">
        <div class="search-filter">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Rechercher une langue...">
        </div>
    </div>

    <!-- Tableau des régions (inséré avant les cartes) -->
    <div class="recent-activity" style="margin-top: 30px;">
        <h2>Liste des Langues</h2>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom Langue</th>
                        <th>Code langue</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($langues) && count($langues))
                        @foreach($langues as $langue)
                        <tr>
                            <td>#{{ $langue->id_langue ?? '—' }}</td>
                            <td>{{ $langue->nom_langue ?? $langue->name ?? '—' }}</td>
                            <td>{{ $langue->code_langue ?? '—' }}</td>
                            <td>{{ Illuminate\Support\Str::limit($langue->description ?? '—', 80) }}</td>

                            <td class="actions">
                                <button type="button" class="btn-icon btn-view" title="Voir" 
                                    data-id="{{ $langue->id_langue ?? '' }}"
                                    data-nom="{{ e($langue->nom_langue ?? '') }}"
                                    data-code="{{ e($langue->code_langue ?? '') }}"
                                    data-desc="{{ e($langue->description ?? '') }}"
                                ><i class="fas fa-eye"></i></button>
                                <button type="button" class="btn-icon btn-edit" title="Modifier"
                                    data-id="{{ $langue->id_langue ?? '' }}"
                                    data-nom="{{ e($langue->nom_langue ?? '') }}"
                                    data-code="{{ e($langue->code_langue ?? '') }}"
                                    data-desc="{{ e($langue->description ?? '') }}"
                                ><i class="fas fa-edit"></i></button>
                                <form action="{{ url('/admin/langues/' . ($langue->id_langue ?? '')) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon btn-delete" onclick="return confirm('Supprimer cette langue ?')" title="Supprimer"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <!-- Exemples statiques si aucune donnée fournie -->
                        <tr>
                            <td>#001</td>
                            <td>Île-de-France</td>
                            <td>Région comprenant Paris et sa couronne.</td>
                            <td>12,012 km²</td>
                            <td class="actions">
                                <button class="btn-icon btn-view"><i class="fas fa-eye"></i></button>
                                <button class="btn-icon btn-edit"><i class="fas fa-edit"></i></button>
                                <button class="btn-icon btn-delete"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#002</td>
                            <td>Provence-Alpes-Côte d'Azur</td>
                            <td>Région du sud-est, bordée par la mer Méditerranée.</td>
                            <td>31,400 km²</td>
                            <td class="actions">
                                <button class="btn-icon btn-view"><i class="fas fa-eye"></i></button>
                                <button class="btn-icon btn-edit"><i class="fas fa-edit"></i></button>
                                <button class="btn-icon btn-delete"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Modal simple pour ajouter une langue -->
    <style>
        /* Modal overlay */
        #langueModal.modal-overlay{ display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1200; align-items:center; justify-content:center; }
        /* Modal content */
        #langueModal .modal-content{
            background: #ffffff;
            padding: 22px;
            width: 92%;
            max-width: 640px;
            border-radius: 12px; /* bords arrondis */
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
            font-family: inherit;
        }
        /* Inputs & textarea */
        #langueModal .form-control{ width:100%; padding:10px 12px; border:1px solid #dcdcdc; border-radius:8px; box-sizing:border-box; }
        #langueModal label{ display:block; font-weight:600; margin-bottom:6px; }
        /* Buttons */
        #langueModal .btn{ background:#f0f0f0; border:1px solid #d0d0d0; padding:8px 14px; border-radius:8px; cursor:pointer; }
        #langueModal .btn-primary{ background:#2d6cdf; color:#fff; border-color:#2660c2; }
        #langueModal .alert{ padding:8px 10px; border-radius:8px; margin-bottom:10px; }
        #langueModal .alert-success{ background:#e6f6ea; color:#0b6b2b; border:1px solid #c8edcf; }
        #langueModal .alert-danger{ background:#fdecea; color:#7a1f1f; border:1px solid #f5c6c6; }
        @media (max-width:480px){ #langueModal .modal-content{ padding:16px; border-radius:10px; } }
    </style>

    <div id="langueModal" class="modal-overlay">
        <div class="modal-content">
            <button id="closeLangueModal" style="position:absolute; right:12px; top:8px; border:none; background:transparent; font-size:18px;">&times;</button>
            <h3>Ajouter une langue</h3>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form id="langueForm" method="POST" action="{{ url('/admin/langues') }}">
                @csrf
                <input type="hidden" name="_method" id="_method_input" value="">
                <div style="margin-bottom:10px;">
                    <label for="nom_langue">Nom de la langue</label>
                    <input id="nom_langue" name="nom_langue" type="text" class="form-control" required />
                </div>
                <div style="margin-bottom:10px;">
                    <label for="code_langue">Code langue</label>
                    <input id="code_langue" name="code_langue" type="text" class="form-control" required />
                </div>
                <div style="margin-bottom:10px;">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" rows="4"></textarea>
                </div>
                <div style="text-align:right; margin-top:12px;">
                    <button type="button" id="cancelLangue" class="btn">Annuler</button>
                    <button type="submit" id="langueSubmitBtn" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        (function(){
            var openBtn = document.getElementById('openLangueModal');
            var modal = document.getElementById('langueModal');
            var closeBtn = document.getElementById('closeLangueModal');
            var cancelBtn = document.getElementById('cancelLangue');
            var form = document.getElementById('langueForm');
            var methodInput = document.getElementById('_method_input');
            var submitBtn = document.getElementById('langueSubmitBtn');
            var titleEl = document.querySelector('#langueModal h3');
            var inputNom = document.getElementById('nom_langue');
            var inputCode = document.getElementById('code_langue');
            var inputDesc = document.getElementById('description');

            function openModal(){ modal.style.display = 'flex'; }
            function closeModal(){ modal.style.display = 'none'; }
            function resetToAdd(){
                form.action = "{{ url('/admin/langues') }}";
                methodInput.value = '';
                submitBtn.textContent = 'Enregistrer';
                titleEl.textContent = 'Ajouter une langue';
                inputNom.value = '';
                inputCode.value = '';
                inputDesc.value = '';
                // s'assurer que les champs sont modifiables et que le bouton submit est visible
                inputNom.disabled = false; inputCode.disabled = false; inputDesc.disabled = false;
                submitBtn.style.display = 'inline-block';
            }

            if(openBtn){ openBtn.addEventListener('click', function(){ resetToAdd(); openModal(); }); }
            if(closeBtn){ closeBtn.addEventListener('click', closeModal); }
            if(cancelBtn){ cancelBtn.addEventListener('click', closeModal); }
            if(modal){ modal.addEventListener('click', function(e){ if(e.target === modal) closeModal(); }); }

            // Delegate click for view and edit buttons
            document.addEventListener('click', function(e){
                var viewBtn = e.target.closest('.btn-view');
                var editBtn = e.target.closest('.btn-edit');
                if(!viewBtn && !editBtn) return;
                e.preventDefault();
                var btn = viewBtn || editBtn;
                var id = btn.getAttribute('data-id');
                var nom = btn.getAttribute('data-nom') || '';
                var code = btn.getAttribute('data-code') || '';
                var desc = btn.getAttribute('data-desc') || '';

                if(viewBtn){
                    // Mode lecture seule
                    form.action = '#';
                    methodInput.value = '';
                    submitBtn.style.display = 'none';
                    titleEl.textContent = 'Détails de la langue';
                    inputNom.value = nom; inputCode.value = code; inputDesc.value = desc;
                    inputNom.disabled = true; inputCode.disabled = true; inputDesc.disabled = true;
                    openModal();
                    return;
                }

                if(editBtn){
                    // Mode édition
                    form.action = '{{ url('/admin/langues') }}/' + id;
                    methodInput.value = 'PUT';
                    submitBtn.style.display = 'inline-block';
                    submitBtn.textContent = 'Modifier';
                    titleEl.textContent = 'Modifier la langue';
                    inputNom.disabled = false; inputCode.disabled = false; inputDesc.disabled = false;
                    inputNom.value = nom; inputCode.value = code; inputDesc.value = desc;
                    openModal();
                    return;
                }
            });
        })();
        
//      
    </script>
    

   

    <!-- Statistiques des langues -->
    <!-- <div class="recent-activity" style="margin-top: 30px;">
        <h2>Statistiques des Langues</h2>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Langue</th>
                        <th>Utilisateurs</th>
                        <th>Contenus</th>
                        <th>Visites</th>
                        <th>Taux de conversion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Français</td>
                        <td>856</td>
                        <td>245</td>
                        <td>5,248</td>
                        <td>12.5%</td>
                    </tr>
                    <tr>
                        <td>English</td>
                        <td>1,245</td>
                        <td>389</td>
                        <td>8,567</td>
                        <td>15.2%</td>
                    </tr>
                    <tr>
                        <td>Español</td>
                        <td>567</td>
                        <td>178</td>
                        <td>3,245</td>
                        <td>9.8%</td>
                    </tr>
                    <tr>
                        <td>Deutsch</td>
                        <td>234</td>
                        <td>89</td>
                        <td>1,567</td>
                        <td>7.2%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> -->
</section>
@endsection