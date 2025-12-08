@extends('frontend.app')
@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-color: #0ea2bd;">
      <div class="container position-relative">
        <div class="d-flex align-items-center gap-3 mb-3">
          <i class="{{ $region->icon }} fa-2x text-white"></i>
          <h1 class="text-white">{{ $region->nom_region }}</h1>
        </div>
        <p class="text-white mb-0">{{ $region->description ?? 'Découvrez tous les contenus de cette région' }}</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('home') }}">Accueil</a></li>
            <li><a href="{{ route('regions') }}">Régions</a></li>
            <li class="current">{{ $region->nom_region }}</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Region Details Section -->
    <section class="region-details section">
      <div class="container">
        
        <!-- Region Overview -->
        <div class="row mb-5">
          <div class="col-lg-8">
            <div class="region-overview">
              <h2 class="mb-4">Aperçu de la région</h2>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="info-item">
                    <i class="bi bi-geo-alt me-2"></i>
                    <strong>Zone :</strong> {{ ucfirst($region->zone) }}
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="info-item">
                    <i class="bi bi-building me-2"></i>
                    <strong>Chef-lieu :</strong> {{ $region->chef_lieu }}
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="info-item">
                    <i class="bi bi-journal-text me-2"></i>
                    <strong>Contenus :</strong> {{ $region->total_contents }}
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="info-item">
                    <i class="bi bi-chat-dots me-2"></i>
                    <strong>Commentaires :</strong> {{ $region->total_comments }}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="region-stats bg-light rounded-3 p-4">
              <h4 class="mb-3">Statistiques</h4>
              <div class="stat-item mb-2">
                <span class="stat-label">Total des contenus :</span>
                <span class="stat-value">{{ $region->total_contents }}</span>
              </div>
              <div class="stat-item mb-2">
                <span class="stat-label">Total des commentaires :</span>
                <span class="stat-value">{{ $region->total_comments }}</span>
              </div>
              <div class="stat-item">
                <span class="stat-label">Langues disponibles :</span>
                <span class="stat-value">{{ $languages->count() }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Languages Distribution -->
        @if($languages->count() > 0)
        <div class="row mb-5">
          <div class="col-12">
            <div class="languages-section">
              <h3 class="mb-4">Répartition par langue</h3>
              <div class="languages-list">
                @foreach($languages as $language)
                <div class="language-item mb-3">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="language-name">{{ $language['name'] }}</span>
                    <span class="language-count">{{ $language['count'] }} contenus ({{ $language['percentage'] }}%)</span>
                  </div>
                  <div class="progress" style="height: 8px;">
                    <div class="progress-bar" role="progressbar" 
                         style="width: {{ $language['percentage'] }}%; background-color: {{ $region->color }};"
                         aria-valuenow="{{ $language['percentage'] }}" 
                         aria-valuemin="0" 
                         aria-valuemax="100"></div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
        @endif

        <!-- Recent Contents -->
        @if($recentContents->count() > 0)
        <div class="row mb-5">
          <div class="col-12">
            <h3 class="mb-4">Contenus récents</h3>
            <div class="row">
              @foreach($recentContents as $content)
              <div class="col-md-4 mb-3">
                <div class="content-card card h-100">
                  <div class="card-body">
                    <h5 class="card-title">{{ Str::limit($content->titre, 50) }}</h5>
                    <p class="card-text text-muted small">
                      {{ Str::limit(strip_tags($content->texte), 80) }}
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="badge bg-light text-dark">
                        <i class="bi bi-chat me-1"></i> {{ $content->commentaires->count() }}
                      </span>
                      <a href="{{ route('content.details', $content->id_contenu) }}" class="btn btn-sm btn-outline-primary">
                        Lire plus
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        @endif

        <!-- Popular Contents -->
        @if($popularContents->count() > 0)
        <div class="row">
          <div class="col-12">
            <h3 class="mb-4">Contenus populaires</h3>
            <div class="row">
              @foreach($popularContents as $content)
              <div class="col-md-6 mb-3">
                <div class="popular-content card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                      <div>
                        <h5 class="card-title">{{ Str::limit($content->titre, 60) }}</h5>
                        <p class="card-text text-muted small mb-2">
                          {{ Str::limit(strip_tags($content->texte), 100) }}
                        </p>
                      </div>
                      <span class="badge" style="background-color: {{ $region->color }};">
                        <i class="bi bi-chat me-1"></i> {{ $content->commentaires->count() }}
                      </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                      <small class="text-muted">
                        <i class="bi bi-calendar me-1"></i> 
                        {{ \Carbon\Carbon::parse($content->date_creation)->format('d/m/Y') }}
                      </small>
                      <a href="{{ route('content.details', $content->id_contenu) }}" class="btn btn-sm btn-primary">
                        Voir le contenu
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        @endif

        <!-- Back Button -->
        <div class="row mt-5">
          <div class="col-12 text-center">
            <a href="{{ route('regions') }}" class="btn btn-outline-secondary">
              <i class="bi bi-arrow-left me-2"></i> Retour à toutes les régions
            </a>
          </div>
        </div>

      </div>
    </section>

</main>
@endsection

@push('styles')
<style>
    .region-overview {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .info-item {
        padding: 10px 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #0ea2bd;
    }
    
    .region-stats {
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .stat-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }
    
    .stat-item:last-child {
        border-bottom: none;
    }
    
    .stat-label {
        color: #666;
    }
    
    .stat-value {
        font-weight: 600;
        color: #333;
    }
    
    .languages-section {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .language-item {
        padding: 10px;
    }
    
    .language-name {
        font-weight: 500;
    }
    
    .language-count {
        font-size: 0.9rem;
        color: #666;
    }
    
    .content-card {
        transition: transform 0.3s ease;
        border: 1px solid #eee;
    }
    
    .content-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .popular-content {
        border-left: 4px solid #0ea2bd;
        transition: all 0.3s ease;
    }
    
    .popular-content:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    @media (max-width: 768px) {
        .region-overview,
        .languages-section {
            padding: 1.5rem;
        }
        
        .info-item {
            margin-bottom: 10px;
        }
    }
</style>
@endpush