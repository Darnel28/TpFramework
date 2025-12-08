<div class="col-12">
  <div class="compact-content d-flex align-items-center gap-3">
    <div class="compact-thumb">
      <img src="{{ asset($content->image ?? 'assets/img/travel/default.jpg') }}" alt="{{ $content->titre ?? 'Contenu' }}" class="img-fluid rounded-2" style="width:90px;height:70px;object-fit:cover;">
    </div>
    <div class="compact-meta">
      <h6 class="mb-1">{{ $content->titre ?? 'Titre' }}</h6>
      <p class="small mb-0 text-muted">{{ isset($content->texte) ? substr($content->texte, 0, 100) . (strlen($content->texte) > 100 ? '...' : '') : '' }}</p>
    </div>
  </div>
</div>
