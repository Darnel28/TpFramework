@extends('frontend.app')
@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-color: #0ea2bd;">
      <div class="container position-relative">
        <h1>Régions du Bénin</h1>
        <p>Explorez la richesse culturelle des 12 régions du Bénin, chacune avec son identité unique</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('home') }}">Accueil</a></li>
            <li class="current">Régions</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Regions Section -->
    <section id="regions" class="regions section">
      <div class="container" data-aos="fade-up">

        <div class="section-header text-center mb-5">
          <h2>Les 12 Régions du Bénin</h2>
          <p class="lead">Découvrez la diversité géographique et culturelle de chaque région</p>
        </div>

        <!-- Region Filters -->
        <div class="region-filters mb-5">
          <div class="row justify-content-center">
            <div class="col-lg-10">
              <div class="filter-tabs d-flex flex-wrap justify-content-center gap-2">
                <button class="filter-btn active" data-filter="*">Toutes les régions</button>
                <button class="filter-btn" data-filter=".nord">Nord</button>
                <button class="filter-btn" data-filter=".centre">Centre</button>
                <button class="filter-btn" data-filter=".sud">Sud</button>
                <button class="filter-btn" data-filter=".ouest">Ouest</button>
              </div>
            </div>
          </div>
        </div><!-- End Region Filters -->

        <!-- Regions Grid -->
        <div class="row gy-4 regions-grid">
          @foreach($regions as $region)
          <div class="col-lg-4 col-md-6 region-item {{ $region['zone'] }}">
            <div class="region-card card h-100 border-0 shadow-sm">
              <div class="card-header bg-white border-0 p-0">
                <div class="region-badge">
                  <span class="badge">{{ $region['contenus_count'] }} contenus</span>
                </div>
              </div>
              <div class="card-body p-4">
                <div class="region-icon mb-3">
                  <i class="{{ $region['icon'] }} fa-2x" style="color: {{ $region['color'] }};"></i>
                </div>
                <h4 class="region-title mb-3">{{ $region['nom_region'] }}</h4>
                <p class="region-description text-muted mb-4">
                  {{ Str::limit($region['description'], 120) }}
                </p>
                <div class="region-meta d-flex justify-content-between text-muted small mb-4">
                  <span><i class="bi bi-geo-alt me-1"></i> {{ ucfirst($region['zone']) }}</span>
                  <span><i class="bi bi-building me-1"></i> {{ $region['chef_lieu'] }}</span>
                </div>
                <a href="{{ route('region.details', $region['id']) }}" class="btn btn-outline-primary w-100">
                  Explorer la région
                  <i class="bi bi-arrow-right ms-2"></i>
                </a>
              </div>
            </div>
          </div><!-- End Region Item -->
          @endforeach
        </div><!-- End Regions Grid -->

        @if(empty($regions))
        <div class="text-center py-5">
          <div class="empty-state">
            <i class="bi bi-geo-alt fa-4x text-muted"></i>
            <h4 class="mt-4 mb-3">Aucune région disponible</h4>
            <p class="text-muted">Les informations sur les régions seront bientôt disponibles.</p>
          </div>
        </div>
        @endif

        <!-- Statistics -->
        <div class="row mt-6 pt-5">
          <div class="col-12">
            <div class="statistics-section bg-light rounded-3 p-4">
              <h3 class="text-center mb-4">Statistiques des Régions</h3>
              <div class="row">
                <div class="col-md-4 mb-3">
                  <div class="stat-item text-center p-3">
                    <div class="stat-number display-6 fw-bold text-primary">{{ count($regions) }}</div>
                    <div class="stat-label text-muted">Régions</div>
                  </div>
                </div>
                <div class="col-md-4 mb-3">
                  <div class="stat-item text-center p-3">
                    <div class="stat-number display-6 fw-bold text-primary">{{ $totalContents }}</div>
                    <div class="stat-label text-muted">Contenus totaux</div>
                  </div>
                </div>
                <div class="col-md-4 mb-3">
                  <div class="stat-item text-center p-3">
                    @if($mostContentRegion)
                    <div class="stat-number fw-bold text-primary" style="font-size: 1.8rem;">
                      {{ $mostContentRegion['nom_region'] }}
                    </div>
                    <div class="stat-subtitle small text-muted">
                      {{ $mostContentRegion['contenus_count'] }} contenus
                    </div>
                    @else
                    <div class="stat-number fw-bold text-primary" style="font-size: 1.8rem;">
                      N/A
                    </div>
                    @endif
                    <div class="stat-label text-muted">Région la plus riche</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Call to Action -->
        <div class="row mt-5">
          <div class="col-lg-8 mx-auto">
            <div class="cta-card bg-primary text-white rounded-3 p-5 text-center">
              <h3 class="text-white mb-3">Explorez la Culture Béninoise</h3>
              <p class="mb-4 opacity-90">
                Chaque région possède ses traditions, ses langues et son patrimoine unique. 
                Plongez au cœur de la diversité culturelle du Bénin.
              </p>
              <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="{{ route('contenus') }}" class="btn btn-light">
                  <i class="bi bi-compass me-2"></i> Explorer les contenus
                </a>
                <a href="{{ route('langues') }}" class="btn btn-outline-light">
                  <i class="bi bi-translate me-2"></i> Découvrir les langues
                </a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section><!-- /Regions Section -->

</main>
@endsection

@push('styles')
<style>
    /* Region Cards */
    .region-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .region-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
    
    .region-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 2;
    }
    
    .region-badge .badge {
        background: rgba(14, 162, 189, 0.9);
        color: white;
        font-weight: 500;
        font-size: 0.8rem;
        padding: 5px 12px;
        border-radius: 20px;
        backdrop-filter: blur(5px);
    }
    
    .region-icon {
        width: 60px;
        height: 60px;
        background: rgba(14, 162, 189, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .region-title {
        font-weight: 600;
        color: #333;
        font-size: 1.3rem;
    }
    
    .region-description {
        font-size: 0.95rem;
        line-height: 1.6;
    }
    
    /* Filter Tabs */
    .filter-tabs {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 12px;
    }
    
    .filter-btn {
        padding: 8px 20px;
        border: 2px solid #e9ecef;
        background: white;
        color: #666;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
        outline: none;
        cursor: pointer;
    }
    
    .filter-btn:hover,
    .filter-btn.active {
        background: #0ea2bd;
        border-color: #0ea2bd;
        color: white;
    }
    
    /* Statistics */
    .statistics-section {
        border: 1px solid #e9ecef;
    }
    
    .stat-item {
        background: white;
        border-radius: 10px;
        transition: transform 0.3s ease;
    }
    
    .stat-item:hover {
        transform: translateY(-5px);
    }
    
    .stat-number {
        color: #0ea2bd;
        margin-bottom: 8px;
    }
    
    .stat-label {
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .stat-subtitle {
        font-size: 0.85rem;
        margin-bottom: 5px;
    }
    
    /* CTA Card */
    .cta-card {
        background: linear-gradient(135deg, #0ea2bd 0%, #0b8ca3 100%);
    }
    
    /* Empty State */
    .empty-state {
        padding: 60px 20px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .filter-tabs {
            padding: 15px;
        }
        
        .filter-btn {
            padding: 6px 15px;
            font-size: 0.9rem;
            flex: 1;
            min-width: 120px;
            margin-bottom: 5px;
        }
        
        .region-card {
            margin-bottom: 20px;
        }
        
        .cta-card {
            padding: 30px 20px !important;
        }
        
        .stat-number.display-6 {
            font-size: 2.5rem;
        }
        
        .region-meta {
            flex-direction: column;
            gap: 5px;
        }
    }
    
    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .region-item {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }
    
    .region-item:nth-child(1) { animation-delay: 0.1s; }
    .region-item:nth-child(2) { animation-delay: 0.2s; }
    .region-item:nth-child(3) { animation-delay: 0.3s; }
    .region-item:nth-child(4) { animation-delay: 0.4s; }
    .region-item:nth-child(5) { animation-delay: 0.5s; }
    .region-item:nth-child(6) { animation-delay: 0.6s; }
    .region-item:nth-child(7) { animation-delay: 0.7s; }
    .region-item:nth-child(8) { animation-delay: 0.8s; }
    .region-item:nth-child(9) { animation-delay: 0.9s; }
    .region-item:nth-child(10) { animation-delay: 1.0s; }
    .region-item:nth-child(11) { animation-delay: 1.1s; }
    .region-item:nth-child(12) { animation-delay: 1.2s; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Simple filter functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        const regionItems = document.querySelectorAll('.region-item');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');
                
                const filterValue = this.getAttribute('data-filter');
                
                // Show/hide region items
                regionItems.forEach(item => {
                    if (filterValue === '*' || item.classList.contains(filterValue.substring(1))) {
                        item.style.display = 'block';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'translateY(0)';
                        }, 10);
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
        
        // Initialize all regions as visible
        regionItems.forEach(item => {
            item.style.display = 'block';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        });
    });
</script>
@endpush