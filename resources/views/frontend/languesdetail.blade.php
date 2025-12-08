@extends('frontend.app')
@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-color: {{ $langue->color ?? '#667eea' }};">
      <div class="container position-relative">
        <div class="d-flex align-items-center gap-3 mb-3">
          <i class="{{ $langue->icon ?? 'bi bi-translate' }} fa-2x text-white"></i>
          <h1 class="text-white">{{ $langue->nom_langue }}</h1>
        </div>
        <p class="text-white mb-0">Découvrez tous les contenus disponibles dans cette langue</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('home') }}">Accueil</a></li>
            <li><a href="{{ route('langues') }}">Patrimoine Linguistique</a></li>
            <li class="current">{{ $langue->nom_langue }}</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Language Details Section -->
    <section class="language-details section">
      <div class="container">
        
        <!-- Language Overview -->
        <div class="row mb-5">
          <div class="col-lg-8">
            <div class="language-overview">
              <h2 class="mb-4">Aperçu de la langue</h2>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="info-item">
                    <i class="bi bi-chat-left-text me-2"></i>
                    <strong>Type :</strong> {{ $langue->type ?? 'Langue régionale' }}
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="info-item">
                    <i class="bi bi-people me-2"></i>
                    <strong>Locuteurs :</strong> {{ $langue->speakers ?? 'Non spécifié' }}
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="info-item">
                    <i class="bi bi-diagram-3 me-2"></i>
                    <strong>Famille linguistique :</strong> {{ $langue->family ?? 'Niger-Congo' }}
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="info-item">
                    <i class="bi bi-geo-alt me-2"></i>
                    <strong>Régions :</strong> {{ $regions->count() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="language-stats bg-light rounded-3 p-4">
              <h4 class="mb-3">Statistiques</h4>
              <div class="stat-item mb-2">
                <span class="stat-label">Contenus disponibles :</span>
                <span class="stat-value">{{ $langue->total_contents }}</span>
              </div>
              <div class="stat-item mb-2">
                <span class="stat-label">Total des commentaires :</span>
                <span class="stat-value">{{ $langue->total_comments }}</span>
              </div>
              <div class="stat-item">
                <span class="stat-label">Régions couvertes :</span>
                <span class="stat-value">{{ $regions->count() }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Regions Distribution -->
        @if($regions->count() > 0)
        <div class="row mb-5">
          <div class="col-12">
            <div class="regions-section">
              <h3 class="mb-4">Répartition par région</h3>
              <div class="regions-list">
                @foreach($regions as $region)
                <div class="region-item mb-3">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="region-name">{{ $region['name'] }}</span>
                    <span class="region-count">{{ $region['count'] }} contenus ({{ $region['percentage'] }}%)</span>
                  </div>
                  <div class="progress" style="height: 8px;">
                    <div class="progress-bar" role="progressbar" 
                         style="width: {{ $region['percentage'] }}%; background-color: {{ $langue->color ?? '#667eea' }};"
                         aria-valuenow="{{ $region['percentage'] }}" 
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
                      <span class="badge" style="background-color: {{ $langue->color ?? '#667eea' }};">
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
            <a href="{{ route('langues') }}" class="btn btn-outline-secondary">
              <i class="bi bi-arrow-left me-2"></i> Retour au patrimoine linguistique
            </a>
          </div>
        </div>

      </div>
    </section>

</main>
@endsection

@push('styles')
<style>
    .language-overview {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .info-item {
        padding: 10px 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #667eea;
    }
    
    .language-stats {
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
    
    .regions-section {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .region-item {
        padding: 10px;
    }
    
    .region-name {
        font-weight: 500;
    }
    
    .region-count {
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
        border-left: 4px solid #667eea;
        transition: all 0.3s ease;
    }
    
    .popular-content:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    @media (max-width: 768px) {
        .language-overview,
        .regions-section {
            padding: 1.5rem;
        }
        
        .info-item {
            margin-bottom: 10px;
        }
    }
</style>
@endpush