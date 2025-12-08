@extends('frontend.app')
@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-color: #0ea2bd;">
      <div class="container position-relative">
        <h1>Patrimoine Linguistique</h1>
        <p>Découvrez la richesse des langues et dialectes du Bénin, véritables trésors de notre héritage culturel</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('home') }}">Accueil</a></li>
            <li class="current">Patrimoine Linguistique</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Languages Section -->
    <section id="languages" class="languages section">
      <div class="container" data-aos="fade-up">

        <div class="section-header text-center mb-5">
          <h2>Les Langues du Bénin</h2>
          <p class="lead mb-4">Explorez la diversité linguistique à travers les 12 régions du pays</p>
          <div class="language-stats">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <div class="stats-card bg-light rounded-3 p-4">
                  <div class="row">
                    <div class="col-md-4 text-center mb-3">
                      <div class="stat-item">
                        <div class="stat-number display-6 fw-bold text-primary">{{ count($langues) }}</div>
                        <div class="stat-label">Langues Répertoriées</div>
                      </div>
                    </div>
                    <div class="col-md-4 text-center mb-3">
                      <div class="stat-item">
                        <div class="stat-number display-6 fw-bold text-primary">{{ $totalContents }}</div>
                        <div class="stat-label">Contenus Disponibles</div>
                      </div>
                    </div>
                    <div class="col-md-4 text-center mb-3">
                      <div class="stat-item">
                        <div class="stat-number display-6 fw-bold text-primary">{{ $mostUsedRegion }}</div>
                        <div class="stat-label">Régions Couvertes</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Language Category Filters -->
        <div class="region-filters mb-5">
          <div class="row justify-content-center">
            <div class="col-lg-10">
              <div class="filter-tabs d-flex flex-wrap justify-content-center gap-2">
                <button class="filter-btn active" data-filter="*">Toutes les langues</button>
                <button class="filter-btn" data-filter=".filter-officielle">Langues Officielles</button>
                <button class="filter-btn" data-filter=".filter-regionale">Langues Régionales</button>
                <button class="filter-btn" data-filter=".filter-locale">Langues Locales</button>
                <button class="filter-btn" data-filter=".filter-traditionnelle">Langues Traditionnelles</button>
              </div>
            </div>
          </div>
        </div><!-- End Region Filters -->

        <!-- Languages Grid -->
        <div class="row gy-4 regions-grid">
          @foreach($langues as $langue)
          <div class="col-lg-4 col-md-6 language-item {{ $langue->filter_category }}">
            <div class="region-card card h-100 border-0 shadow-sm">
              <div class="card-header bg-white border-0 p-0">
                <div class="region-badge">
                  <span class="badge">{{ $langue->contents_count ?? 0 }} contenus</span>
                </div>
              </div>
              <div class="card-body p-4">
                <div class="region-icon mb-3">
                  <i class="{{ $langue->icon }} fa-2x" style="color: {{ $langue->color }};"></i>
                </div>
                <h4 class="region-title mb-3">{{ $langue->nom_langue }}</h4>
                <p class="region-description text-muted mb-4">
                  {{ Str::limit($langue->description ?? 'Langue parlée au Bénin avec son patrimoine culturel unique.', 100) }}
                </p>
                <div class="region-meta d-flex justify-content-between text-muted small mb-4">
                  <span><i class="bi bi-tag me-1"></i> {{ $langue->type }}</span>
                  <span><i class="bi bi-geo-alt me-1"></i> {{ $langue->region_count }} régions</span>
                </div>
                <!-- <div class="language-info mb-4"> -->
                  <!-- <div class="row text-center">
                    <div class="col-6">
                      <div class="info-item">
                        <div class="info-label small text-muted">Locuteurs</div>
                        <div class="info-value fw-bold">{{ $langue->speakers ?? 'Non spécifié' }}</div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="info-item">
                        <div class="info-label small text-muted">Famille</div>
                        <div class="info-value fw-bold">{{ $langue->family ?? 'Africaine' }}</div>
                      </div>
                    </div>
                  </div> -->
                <!-- </div> -->
                <div class="language-actions">
                  <a href="{{ route('contenus') }}?langue={{ $langue->id_langue }}" class="btn btn-outline-primary w-100">
                    <i class="bi bi-journal-text me-1"></i> Explorer les contenus
                  </a>
                </div>
              </div>
            </div>
          </div><!-- End Language Item -->
          @endforeach
        </div><!-- End Languages Grid -->

        @if($langues->isEmpty())
        <div class="text-center py-5">
          <div class="empty-state">
            <i class="bi bi-translate fa-4x text-muted mb-3"></i>
            <h4 class="mt-4 mb-3">Aucune langue disponible</h4>
            <p class="text-muted">Les informations linguistiques seront bientôt disponibles.</p>
          </div>
        </div>
        @endif

        <!-- Call to Action -->
        <div class="row mt-5">
          <div class="col-lg-8 mx-auto">
            <div class="cta-card bg-primary text-white rounded-3 p-5 text-center">
              <h3 class="text-white mb-3">Contribuez au Patrimoine Linguistique</h3>
              <p class="mb-4 opacity-90">
                Participez à la préservation et à la valorisation des langues béninoises en partageant vos connaissances et documents.
              </p>
              <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="{{ route('contribute') }}" class="btn btn-light">
                  <i class="bi bi-plus-circle me-2"></i> Contribuer
                </a>
                <a href="{{ route('contenus') }}" class="btn btn-outline-light">
                  <i class="bi bi-compass me-2"></i> Explorer les ressources
                </a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section><!-- /Languages Section -->

</main>
@endsection

@push('styles')
<style>
    /* Region/Language Cards */
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
    
    .region-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 15px;
    }
    
    /* Language Info */
    .language-info {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
    
    .info-item {
        padding: 5px 0;
    }
    
    .info-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 3px;
    }
    
    .info-value {
        color: #0ea2bd;
        font-size: 1rem;
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
    
    /* Stats Card */
    .stats-card {
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
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
        color: #666;
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
            min-width: 140px;
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
            align-items: flex-start;
        }
        
        .language-info .row {
            flex-direction: column;
            gap: 10px;
        }
        
        .language-info .col-6 {
            width: 100%;
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
    
    .language-item {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }
    
    /* Animation delays for items */
    .language-item:nth-child(1) { animation-delay: 0.1s; }
    .language-item:nth-child(2) { animation-delay: 0.2s; }
    .language-item:nth-child(3) { animation-delay: 0.3s; }
    .language-item:nth-child(4) { animation-delay: 0.4s; }
    .language-item:nth-child(5) { animation-delay: 0.5s; }
    .language-item:nth-child(6) { animation-delay: 0.6s; }
    .language-item:nth-child(7) { animation-delay: 0.7s; }
    .language-item:nth-child(8) { animation-delay: 0.8s; }
    .language-item:nth-child(9) { animation-delay: 0.9s; }
    .language-item:nth-child(10) { animation-delay: 1.0s; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Simple filter functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        const languageItems = document.querySelectorAll('.language-item');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');
                
                const filterValue = this.getAttribute('data-filter');
                
                // Show/hide language items
                languageItems.forEach(item => {
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
        
        // Initialize all languages as visible
        languageItems.forEach(item => {
            item.style.display = 'block';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        });
    });
</script>
@endpush