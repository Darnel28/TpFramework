@extends('dashboard.layout')

@section('content')
<section id="regions" class="content-section active">
    <div class="section-header">
        <h1>Gestion des Régions</h1>
        <button id="openRegionModal" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter une région
        </button>
    </div>

    <div class="section-search">
        <div class="search-filter">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Rechercher une région...">
        </div>
    </div>

    <!-- Tableau des régions -->
    <div class="recent-activity" style="margin-top: 30px;">
        <h2>Liste des Régions</h2>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom Région</th>
                        <th>Description</th>
                        <th>Superficie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($regions) && count($regions))
                        @foreach($regions as $region)
                        <tr>
                            <td>#{{ $region->id ?? '—' }}</td>
                            <td>{{ $region->nom_region ?? '—' }}</td>
                            <td>{{ Illuminate\Support\Str::limit($region->description ?? '—', 80) }}</td>
                            <td>{{ $region->superficie ?? '—' }}</td>
                            <td class="actions">
                                <button type="button" class="btn-icon btn-view" 
                                    data-id="{{ $region->id }}"
                                    data-nom="{{ e($region->nom_region) }}"
                                    data-desc="{{ e($region->description) }}"
                                    data-pop="{{ e($region->population) }}"
                                    data-surf="{{ e($region->superficie) }}"
                                    data-loc="{{ e($region->localisation) }}"
                                ><i class="fas fa-eye"></i></button>

                                <button type="button" class="btn-icon btn-edit"
                                    data-id="{{ $region->id }}"
                                    data-nom="{{ e($region->nom_region) }}"
                                    data-desc="{{ e($region->description) }}"
                                    data-pop="{{ e($region->population) }}"
                                    data-surf="{{ e($region->superficie) }}"
                                    data-loc="{{ e($region->localisation) }}"
                                ><i class="fas fa-edit"></i></button>

                                <form action="{{ url('/admin/regions/' . $region->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon btn-delete" onclick="return confirm('Supprimer cette région ?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr><td colspan="5">Aucune région trouvée.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal pour régions -->
    <div id="regionModal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <button id="closeRegionModal" style="position:absolute; right:12px; top:8px; border:none; background:transparent; font-size:18px;">&times;</button>
            <h3>Ajouter une région</h3>
            <form id="regionForm" method="POST" action="{{ url('/admin/regions') }}">
                @csrf
                <input type="hidden" name="_method" id="region_method" value="">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label>Nom région</label>
                        <input id="nom_region" name="nom_region" class="form-control" required />
                    </div>
                    <div>
                        <label>Population</label>
                        <input id="population" name="population" type="number" class="form-control" />
                    </div>
                </div>
                <div style="margin-top:8px;">
                    <label>Superficie</label>
                    <input id="superficie" name="superficie" class="form-control" />
                </div>
                <div style="margin-top:8px;">
                    <label>Localisation</label>
                    <input id="localisation" name="localisation" class="form-control" />
                </div>
                <div style="margin-top:8px;">
                    <label>Description</label>
                    <textarea id="region_description" name="description" class="form-control" rows="4"></textarea>
                </div>
                <div style="text-align:right; margin-top:12px;">
                    <button type="button" id="cancelRegion" class="btn">Annuler</button>
                    <button type="submit" id="regionSubmit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        #regionModal.modal-overlay{ position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1200; align-items:center; justify-content:center; display:flex; }
        #regionModal .modal-content{ background:#fff; padding:20px; max-width:720px; width:95%; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.2); position:relative; }
        #regionModal .form-control{ width:100%; padding:8px; border-radius:8px; border:1px solid #ddd; }
        #regionModal .btn{ border-radius:8px; padding:8px 12px; }
    </style>

    <script>
        (function(){
            var openBtn = document.getElementById('openRegionModal');
            var modal = document.getElementById('regionModal');
            var closeBtn = document.getElementById('closeRegionModal');
            var cancelBtn = document.getElementById('cancelRegion');
            var form = document.getElementById('regionForm');
            var methodInput = document.getElementById('region_method');
            var submitBtn = document.getElementById('regionSubmit');
            var titleEl = document.querySelector('#regionModal h3');

            function openModal(){ modal.style.display = 'flex'; }
            function closeModal(){ modal.style.display = 'none'; }

            function resetForm(){
                form.action = "{{ url('/admin/regions') }}";
                methodInput.value = '';
                submitBtn.textContent = 'Enregistrer';
                titleEl.textContent = 'Ajouter une région';
                document.getElementById('nom_region').value='';
                document.getElementById('population').value='';
                document.getElementById('superficie').value='';
                document.getElementById('localisation').value='';
                document.getElementById('region_description').value='';
                document.getElementById('nom_region').disabled=false;
                submitBtn.style.display='inline-block';
            }

            if(openBtn) openBtn.addEventListener('click', function(){ resetForm(); openModal(); });
            if(closeBtn) closeBtn.addEventListener('click', closeModal);
            if(cancelBtn) cancelBtn.addEventListener('click', closeModal);
            if(modal) modal.addEventListener('click', function(e){ if(e.target===modal) closeModal(); });

            document.addEventListener('click', function(e){
                var viewBtn = e.target.closest('.btn-view');
                var editBtn = e.target.closest('.btn-edit');
                if(!viewBtn && !editBtn) return;

                var btn = viewBtn || editBtn;
                var id = btn.getAttribute('data-id');
                var nom = btn.getAttribute('data-nom') || '';
                var desc = btn.getAttribute('data-desc') || '';
                var pop = btn.getAttribute('data-pop') || '';
                var surf = btn.getAttribute('data-surf') || '';
                var loc = btn.getAttribute('data-loc') || '';

                if(viewBtn){
                    form.action = '#'; methodInput.value=''; submitBtn.style.display='none'; titleEl.textContent='Détails de la région';
                    document.getElementById('nom_region').value=nom;
                    document.getElementById('population').value=pop;
                    document.getElementById('superficie').value=surf;
                    document.getElementById('localisation').value=loc;
                    document.getElementById('region_description').value=desc;
                    document.getElementById('nom_region').disabled=true;
                    openModal();
                }

                if(editBtn){
                    form.action = '{{ url('/admin/regions') }}/' + id;
                    methodInput.value='PUT';
                    submitBtn.style.display='inline-block';
                    submitBtn.textContent='Modifier';
                    titleEl.textContent='Modifier la région';
                    document.getElementById('nom_region').disabled=false;
                    document.getElementById('nom_region').value=nom;
                    document.getElementById('population').value=pop;
                    document.getElementById('superficie').value=surf;
                    document.getElementById('localisation').value=loc;
                    document.getElementById('region_description').value=desc;
                    openModal();
                }
            });
        })();
    </script>

</section>
@endsection
