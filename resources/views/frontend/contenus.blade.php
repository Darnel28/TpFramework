@extends('frontend.app')
@section('content')
<main class="main">

    <!-- Page Title -->
    <!-- <div class="page-title dark-background" data-aos="fade" style="background-image: url({{ asset('assets/img/travel/showcase-8.webp') }});"> -->
       <div class="page-title dark-background" data-aos="fade" style="background-color: #0ea2bd;">
      <div class="container position-relative">
        <h1>Contenus Culturels</h1>
        <p>Explorez la richesse culturelle du Bénin à travers nos contenus diversifiés : histoires, traditions, musiques et recettes.</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('home') }}">Accueil</a></li>
            <li class="current">Contenus</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Travel Tours Section -->
    <section id="travel-tours" class="travel-tours section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
          <div class="col-lg-8 mx-auto text-center mb-5">
            <h2>Explorez la Culture Béninoise</h2>
            <p>Découvrez notre collection de contenus culturels. Utilisez les filtres pour trouver ce qui vous intéresse ou parcourez nos sélections spéciales.</p>
          </div>
        </div>

        <!-- Search and Filters -->
        <div class="row mb-5" data-aos="fade-up" data-aos-delay="200">
          <div class="col-12">
            <form method="GET" action="{{ route('contenus') }}" class="tour-filters">
              <div class="row g-3">
                <!-- Search Bar -->
                <div class="col-lg-4 col-md-6">
                  <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                      <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Rechercher un contenu..." 
                           value="{{ request('search') }}">
                  </div>
                </div>
                
                <!-- Region Filter -->
                <div class="col-lg-3 col-md-6">
                  <select class="form-select" name="region" onchange="this.form.submit()">
                    <option value="">Toutes les régions</option>
                    @foreach($regions as $region)
                    <option value="{{ $region->id_region }}" 
                            {{ request('region') == $region->id_region ? 'selected' : '' }}>
                      {{ $region->nom_region }}
                    </option>
                    @endforeach
                  </select>
                </div>
                
                <!-- Language Filter -->
                <div class="col-lg-3 col-md-6">
                  <select class="form-select" name="langue" onchange="this.form.submit()">
                    <option value="">Toutes les langues</option>
                    @foreach($langues as $langue)
                    <option value="{{ $langue->id_langue }}" 
                            {{ request('langue') == $langue->id_langue ? 'selected' : '' }}>
                      {{ $langue->nom_langue }}
                    </option>
                    @endforeach
                  </select>
                </div>
                
                <!-- Sort Options -->
                <div class="col-lg-2 col-md-6">
                  <select class="form-select" name="date" onchange="this.form.submit()">
                    <option value="">Trier par</option>
                    <option value="recent" {{ request('date') == 'recent' ? 'selected' : '' }}>Plus récent</option>
                    <option value="ancien" {{ request('date') == 'ancien' ? 'selected' : '' }}>Plus ancien</option>
                    <option value="populaire" {{ request('popularite') == 'populaire' ? 'selected' : '' }}>Plus populaire</option>
                  </select>
                </div>
              </div>
              
              <!-- Active Filters Display -->
              @if(request()->anyFilled(['search', 'region', 'langue', 'date']))
              <div class="row mt-3">
                <div class="col-12">
                  <div class="active-filters">
                    <small class="text-muted">Filtres actifs :</small>
                    @if(request('search'))
                    <span class="badge bg-primary me-2">
                      Recherche: "{{ request('search') }}"
                      <a href="{{ route('contenus', array_merge(request()->except('search'), ['page' => 1])) }}" 
                         class="text-white ms-1" style="text-decoration: none;">×</a>
                    </span>
                    @endif
                    
                    @if(request('region'))
                    @php $selectedRegion = $regions->firstWhere('id_region', request('region')) @endphp
                    @if($selectedRegion)
                    <span class="badge bg-info me-2">
                      Région: {{ $selectedRegion->nom_region }}
                      <a href="{{ route('contenus', array_merge(request()->except('region'), ['page' => 1])) }}" 
                         class="text-white ms-1" style="text-decoration: none;">×</a>
                    </span>
                    @endif
                    @endif
                    
                    @if(request('langue'))
                    @php $selectedLangue = $langues->firstWhere('id_langue', request('langue')) @endphp
                    @if($selectedLangue)
                    <span class="badge bg-success me-2">
                      Langue: {{ $selectedLangue->nom_langue }}
                      <a href="{{ route('contenus', array_merge(request()->except('langue'), ['page' => 1])) }}" 
                         class="text-white ms-1" style="text-decoration: none;">×</a>
                    </span>
                    @endif
                    @endif
                    
                    <a href="{{ route('contenus') }}" class="btn btn-sm btn-outline-secondary">
                      <i class="bi bi-x-circle"></i> Effacer tous les filtres
                    </a>
                  </div>
                </div>
              </div>
              @endif
            </form>
          </div>
        </div>

        <!-- Featured Contents Slider -->
        @if($popularContents->isNotEmpty())
        <div class="row mb-5" data-aos="fade-up" data-aos-delay="300">
          <div class="col-12">
            <h3 class="section-subtitle mb-4">Contenus Populaires</h3>
            <div class="featured-tours-slider swiper init-swiper">
              <script type="application/json" class="swiper-config">
                {
                  "loop": true,
                  "speed": 600,
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": 1,
                  "spaceBetween": 30,
                  "pagination": {
                    "el": ".swiper-pagination",
                    "type": "bullets",
                    "clickable": true
                  },
                  "breakpoints": {
                    "768": {
                      "slidesPerView": 2
                    },
                    "1200": {
                      "slidesPerView": 3
                    }
                  }
                }
              </script>
              <div class="swiper-wrapper">
                @foreach($popularContents as $content)
                <div class="swiper-slide">
                  <div class="featured-tour-card">
                    <div class="tour-image">
                      @if($content->image)
                        <img src="{{ $content->image_url }}" alt="{{ $content->titre }}" class="img-fluid">
                      @else
                        <img src="{{ asset('assets/img/travel/default.jpg') }}" alt="{{ $content->titre }}" class="img-fluid">
                      @endif
                      <div class="tour-badge">Populaire</div>
                    </div>
                    <div class="tour-content">
                      <h4>{{ Str::limit($content->titre, 50) }}</h4>
                      <p>{{ $content->excerpt }}</p>
                      <div class="tour-meta">
                        @if($content->region)
                          <span class="region"><i class="bi bi-geo-alt"></i> {{ $content->region->nom_region }}</span>
                        @endif
                        <span class="comments"><i class="bi bi-chat"></i> {{ $content->comment_count }} commentaires</span>
                      </div>
                      <a href="{{ route('content.details', $content->id_contenu) }}" class="btn btn-primary">Voir Plus</a>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>
        @endif

        <!-- Categories -->
        <div class="row mb-5" data-aos="fade-up" data-aos-delay="400">
          <div class="col-12">
            <h3 class="section-subtitle mb-4">Parcourir par Région</h3>
            <div class="row">
              @foreach($regions->take(6) as $region)
              <div class="col-lg-2 col-md-4 col-6 mb-3">
                <a href="{{ route('contenus', ['region' => $region->id_region]) }}" class="text-decoration-none">
                  <div class="category-card hover-effect">
                    <div class="category-icon">
                      <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h5>{{ $region->nom_region }}</h5>
                    <small class="text-muted">
                      {{ $region->contenus()->count() }} contenu(s)
                    </small>
                  </div>
                </a>
              </div>
              @endforeach
              @if($regions->count() > 6)
              <div class="col-lg-2 col-md-4 col-6 mb-3">
                <a href="{{ route('regions') }}" class="text-decoration-none">
                  <div class="category-card hover-effect">
                    <div class="category-icon">
                      <i class="bi bi-plus-circle"></i>
                    </div>
                    <h5>Voir toutes</h5>
                    <small class="text-muted">Les régions</small>
                  </div>
                </a>
              </div>
              @endif
            </div>
          </div>
        </div>

        <!-- Latest Contents -->
        @if($recentContents->isNotEmpty())
        <div class="row mb-5" data-aos="fade-up" data-aos-delay="500">
          <div class="col-12">
            <div class="special-offers">
              <h3 class="section-subtitle mb-4">Contenus Récents</h3>
              <div class="row">
                @foreach($recentContents as $content)
                <div class="col-lg-4 mb-4">
                  <div class="offer-banner">
                    <div class="offer-content">
                      <div class="new-badge">NOUVEAU</div>
                      <h4>{{ Str::limit($content->titre, 40) }}</h4>
                      <p>{{ $content->excerpt }}</p>
                      <div class="offer-meta">
                        <span><i class="bi bi-calendar"></i> {{ $content->formatted_date }}</span>
                        @if($content->region)
                          <span><i class="bi bi-geo-alt"></i> {{ $content->region->nom_region }}</span>
                        @endif
                      </div>
                      <a href="{{ route('content.details', $content->id_contenu) }}" class="btn btn-accent">Lire</a>
                    </div>
                    <div class="offer-image">
                      @if($content->image)
                        <img src="{{ $content->image_url }}" alt="{{ $content->titre }}" class="img-fluid">
                      @else
                        <img src="{{ asset('assets/img/travel/default.jpg') }}" alt="{{ $content->titre }}" class="img-fluid">
                      @endif
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
        @endif

        <!-- All Contents Grid -->
        <div class="row" data-aos="fade-up" data-aos-delay="600">
          <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h3 class="section-subtitle mb-0">Tous les Contenus</h3>
              <div class="total-count">
                <span class="badge bg-primary">{{ $contents->total() }} contenu(s) trouvé(s)</span>
              </div>
            </div>
            
            @if($contents->isEmpty())
            <div class="text-center py-5">
              <div class="empty-state">
                <i class="bi bi-journal-x" style="font-size: 4rem; color: #ccc;"></i>
                <h4 class="mt-3">Aucun contenu trouvé</h4>
                <p class="text-muted">Essayez de modifier vos filtres ou explorez nos autres sections.</p>
                <a href="{{ route('contenus') }}" class="btn btn-primary mt-3">
                  <i class="bi bi-arrow-clockwise"></i> Réinitialiser les filtres
                </a>
              </div>
            </div>
            @else
            <div class="row">
              @foreach($contents as $content)
              <div class="col-lg-4 col-md-6 mb-4">
                <div class="tour-card h-100">
                  <div class="tour-image">
                    @if($content->image)
                      <img src="{{ $content->image_url }}" alt="{{ $content->titre }}" class="img-fluid">
                    @else
                      <img src="{{ asset('assets/img/travel/default.jpg') }}" alt="{{ $content->titre }}" class="img-fluid">
                    @endif
                    @if($content->commentaires->count() >= 10)
                      <div class="tour-price">Populaire</div>
                    @endif
                  </div>
                  <div class="tour-content">
                    <h4>{{ Str::limit($content->titre, 60) }}</h4>
                    <p>{{ $content->excerpt }}</p>
                    <div class="tour-details">
                      @if($content->region)
                        <span><i class="bi bi-geo-alt"></i> {{ $content->region->nom_region }}</span>
                      @endif
                      <span><i class="bi bi-chat"></i> {{ $content->comment_count }}</span>
                      <span><i class="bi bi-star-fill"></i> {{ number_format($content->rating, 1) }}</span>
                    </div>
                    <div class="tour-footer">
                      <small class="text-muted">
                        <i class="bi bi-calendar"></i> {{ $content->formatted_date }}
                      </small>
                      <a href="{{ route('content.details', $content->id_contenu) }}" class="btn btn-outline-primary btn-sm">
                        Voir Plus
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            
            <!-- Pagination -->
            @if($contents->hasPages())
            <div class="row mt-4">
              <div class="col-12">
                <nav aria-label="Page navigation">
                  <ul class="pagination justify-content-center">
                    {{-- Previous Page Link --}}
                    @if ($contents->onFirstPage())
                    <li class="page-item disabled">
                      <span class="page-link">
                        <i class="bi bi-chevron-left"></i>
                      </span>
                    </li>
                    @else
                    <li class="page-item">
                      <a class="page-link" href="{{ $contents->previousPageUrl() }}" rel="prev">
                        <i class="bi bi-chevron-left"></i>
                      </a>
                    </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($contents->links()->elements[0] as $page => $url)
                    @if ($page == $contents->currentPage())
                    <li class="page-item active">
                      <span class="page-link">{{ $page }}</span>
                    </li>
                    @else
                    <li class="page-item">
                      <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                    @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($contents->hasMorePages())
                    <li class="page-item">
                      <a class="page-link" href="{{ $contents->nextPageUrl() }}" rel="next">
                        <i class="bi bi-chevron-right"></i>
                      </a>
                    </li>
                    @else
                    <li class="page-item disabled">
                      <span class="page-link">
                        <i class="bi bi-chevron-right"></i>
                      </span>
                    </li>
                    @endif
                  </ul>
                </nav>
                
                <div class="text-center text-muted mt-2">
                  <small>
                    Affichage de {{ $contents->firstItem() }} à {{ $contents->lastItem() }} sur {{ $contents->total() }} contenus
                  </small>
                </div>
              </div>
            </div>
            @endif
            @endif
          </div>
        </div>

        <!-- CTA Section -->
        <div class="row mt-5" data-aos="fade-up" data-aos-delay="700">
          <div class="col-12">
            <div class="cta-section text-center">
              <h3>Vous avez un contenu à partager ?</h3>
              <p>Contribuez à la préservation de la culture béninoise en partageant vos histoires, traditions et connaissances.</p>
              <div class="cta-buttons">
                <a href="{{ route('contribute') }}" class="btn btn-primary me-3">
                  <i class="bi bi-plus-circle"></i> Contribuer
                </a>
                <a href="{{ route('langues') }}" class="btn btn-outline-primary">
                  <i class="bi bi-translate"></i> Découvrir les langues
                </a>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Travel Tours Section -->

  </main>
@endsection

@push('styles')
<style>
    /* Search and Filters */
    .input-group-text {
        border-radius: 0.375rem 0 0 0.375rem;
    }
    
    .active-filters {
        padding: 10px;
        background: #f8f9fa;
        border-radius: 5px;
        border: 1px solid #dee2e6;
    }
    
    /* Category Cards */
    .category-card {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .category-card.hover-effect:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        border-color: #0ea2bd;
    }
    
    .category-icon {
        font-size: 2rem;
        color: #0ea2bd;
        margin-bottom: 10px;
    }
    
    /* Tour Cards */
    .tour-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        height: 100%;
    }
    
    .tour-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    
    .tour-image {
        position: relative;
        height: 200px;
        overflow: hidden;
    }
    
    .tour-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .tour-card:hover .tour-image img {
        transform: scale(1.05);
    }
    
    .tour-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #ff6b6b;
        color: white;
        padding: 5px 10px;
        border-radius: 3px;
        font-size: 0.8rem;
        font-weight: bold;
    }
    
    .tour-price {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: #0ea2bd;
        color: white;
        padding: 5px 10px;
        border-radius: 3px;
        font-weight: bold;
    }
    
    .tour-content {
        padding: 20px;
        display: flex;
        flex-direction: column;
        height: calc(100% - 200px);
    }
    
    .tour-content h4 {
        font-size: 1.1rem;
        margin-bottom: 10px;
        color: #333;
        line-height: 1.3;
    }
    
    .tour-content p {
        color: #666;
        font-size: 0.9rem;
        line-height: 1.5;
        flex-grow: 1;
    }
    
    .tour-details {
        display: flex;
        justify-content: space-between;
        margin: 15px 0;
        font-size: 0.85rem;
        color: #777;
    }
    
    .tour-details span {
        display: flex;
        align-items: center;
    }
    
    .tour-details i {
        margin-right: 5px;
    }
    
    .tour-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }
    
    /* Offer Banner */
    .offer-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        overflow: hidden;
        display: flex;
        color: white;
        height: 100%;
    }
    
    .offer-content {
        padding: 30px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .offer-image {
        flex: 1;
        position: relative;
    }
    
    .offer-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .new-badge {
        background: rgba(255,255,255,0.2);
        padding: 5px 15px;
        border-radius: 20px;
        display: inline-block;
        margin-bottom: 15px;
        font-size: 0.9rem;
        backdrop-filter: blur(10px);
    }
    
    .offer-meta {
        margin: 15px 0;
        font-size: 0.9rem;
        opacity: 0.9;
    }
    
    .offer-meta span {
        margin-right: 15px;
    }
    
    .btn-accent {
        background: white;
        color: #667eea;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: bold;
        align-self: flex-start;
        margin-top: 15px;
        transition: all 0.3s ease;
    }
    
    .btn-accent:hover {
        background: #f8f9fa;
        transform: translateY(-2px);
    }
    
    /* Empty State */
    .empty-state {
        padding: 50px 20px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .offer-banner {
            flex-direction: column;
        }
        
        .offer-image {
            height: 200px;
        }
        
        .tour-details {
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .category-card {
            padding: 15px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Swiper
        const swiperEl = document.querySelector('.featured-tours-slider .init-swiper');
        if (swiperEl) {
            const swiperConfig = JSON.parse(swiperEl.querySelector('.swiper-config').textContent);
            new Swiper('.featured-tours-slider .swiper', swiperConfig);
        }
        
        // Auto-submit sort select
        document.querySelectorAll('select[name="date"], select[name="popularite"]').forEach(select => {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });
        
        // Search debounce
        let searchTimeout;
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.addEventListener('keyup', function(e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    if (this.value.length >= 3 || this.value.length === 0) {
                        this.form.submit();
                    }
                }, 500);
            });
        }
    });
</script>
@endpush