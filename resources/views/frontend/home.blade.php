@extends('frontend.app')

@section('title', 'Accueil - Culture Bénin')
@section('description', 'Explorez la richesse culturelle du Bénin : histoires, contes, musiques, danses et traditions')

@section('content')
  <!-- Travel Hero Section -->
  <section id="travel-hero" class="travel-hero section dark-background">
    <div class="hero-background">
      <video autoplay muted loop>
        <source src="{{ asset('assets/img/travel/video1.mp4') }}" type="video/mp4">
      </video>
      <div class="hero-overlay"></div>
    </div>

    <div class="container position-relative">
      <div class="row align-items-center">
        <div class="col-lg-7">
          <div class="hero-text" data-aos="fade-up" data-aos-delay="100">
            <h1 class="hero-title">Mi Kwuabo – Explorez l'Essence du Bénin</h1>
            <p class="hero-subtitle">Un voyage authentique au cœur d'un pays où chaque lieu raconte une histoire et chaque rencontre laisse un souvenir.</p>
            <div class="hero-buttons">
              <a href="{{ route('contenus') }}" class="btn btn-primary me-3">Explorer</a>
              <a href="{{ route('contribute') }}" class="btn btn-outline">Contribuer</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Why Us Section -->
  <section id="why-us" class="why-us section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <!-- About Us Content -->
      <div class="row align-items-center mb-5">
        <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
          <div class="content">
            <h3>Découvrez le Bénin Authentique</h3>
            <p>Plongez au cœur de la culture béninoise : histoires, contes, musiques, danses, plats traditionnels et langues locales.</p>
            <p>Explorez les différentes régions du Bénin et participez à la préservation de son patrimoine unique.</p>
            <div class="stats-row">
              <div class="stat-item">
                <span data-purecounter-start="0" data-purecounter-end="{{ \App\Models\Contenu::count() }}" data-purecounter-duration="2" class="purecounter">0</span>
                <div class="stat-label">Contenus culturels</div>
              </div>
              <div class="stat-item">
                <span data-purecounter-start="0" data-purecounter-end="{{ \App\Models\Langue::count() }}" data-purecounter-duration="2" class="purecounter">0</span>
                <div class="stat-label">Langues et dialectes documentés</div>
              </div>
              <div class="stat-item">
                <span data-purecounter-start="0" data-purecounter-end="{{ \App\Models\Region::count() }}" data-purecounter-duration="2" class="purecounter">0</span>
                <div class="stat-label">Régions explorées</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
          <div class="about-image">
            <img src="{{ asset('assets/img/travel/Porte.jpeg') }}" alt="Paysage Bénin" class="img-fluid rounded-4">
            <!-- <div class="experience-badge"> -->
              <!-- <div class="experience-number">15+</div> -->
              <!-- <div class="experience-text">Années </div> -->
            <!-- </div> -->
          </div>
        </div>
      </div>

      <!-- Why Choose Us -->
      <div class="why-choose-section">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-center mb-5" data-aos="fade-up" data-aos-delay="100">
            <h3>Pourquoi Choisir Notre Plateforme Culturelle</h3>
            <p>Explorez, partagez et découvrez le patrimoine unique du Bénin grâce à une plateforme interactive et sécurisée.</p>
          </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="feature-card">
                <div class="feature-icon">
                  <i class="bi bi-people-fill"></i>
                </div>
                <h4>Experts Locaux</h4>
                <p>Nos contributeurs et modérateurs connaissent parfaitement les traditions et coutumes béninoises.</p>
              </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="250">
              <div class="feature-card">
                <div class="feature-icon">
                  <i class="bi bi-shield-check"></i>
                </div>
                <h4>Sécurisé &amp;  Fiable</h4>
                <p>Une plateforme sûre pour la consultation et la contribution de contenus culturels authentiques.</p>
              </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="feature-card">
                <div class="feature-icon">
                  <i class="bi bi-cash"></i>
                </div>
                <h4>Contenus Diversifiés</h4>
                <p>Histoires, recettes, vidéos et audios, enrichis de textes et traductions en langues locales.</p>
              </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="350">
              <div class="feature-card">
                <div class="feature-icon">
                  <i class="bi bi-headset"></i>
                </div>
                <h4>Support Communautaire</h4>
                <p>Des modérateurs et contributeurs disponibles pour guider, valider et enrichir les contenus.</p>
              </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="feature-card">
                <div class="feature-icon">
                  <i class="bi bi-geo-alt-fill"></i>
                </div>
                <h4>Découverte des Régions</h4>
                <p>Explorez le patrimoine culturel à travers les différentes régions du Bénin et leurs spécificités.</p>
              </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="450">
              <div class="feature-card">
                <div class="feature-icon">
                  <i class="bi bi-star-fill"></i>
                </div>
                <h4>Expérience Premium</h4>
                <p>Une interface moderne et interactive qui valorise chaque contribution et favorise l'échange culturel.</p>
              </div>
            </div>
          </div>
      </div>
    </div>
  </section>

  <!-- Featured Content Section -->
  <section id="featured-content" class="featured-destinations section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Actu & Tendances</h2>
      <div><span>À Ne Pas Manquer </span> <span class="description-title">Aujourd'hui</span></div>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row">
        <!-- Contenu principal (Featured) -->
        @if($featured)
        <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="200">
          <div class="featured-destination">
            <div class="destination-overlay">
              @if($featured->image)
                <img src="{{ $featured->image_url }}" alt="{{ $featured->titre }}" class="img-fluid">
              @else
                <img src="{{ asset('assets/img/travel/default.jpg') }}" alt="{{ $featured->titre }}" class="img-fluid">
              @endif
              <div class="destination-info">
                <h3>{{ $featured->titre }}</h3>
                <p class="location"><i class="bi bi-geo-alt-fill"></i> {{ $featured->region->nom_region }}</p>
                <p class="description">{{ $featured->excerpt }}</p>
                <div class="destination-meta">
                  <div class="tours-count">
                    <i class="bi bi-collection"></i>
                    <span>{{ $featured->comment_count }} commentaire(s)</span>
                  </div>
                  <div class="rating">
                    <i class="bi bi-star-fill"></i>
                    <span>{{ $featured->formatted_rating }}</span>
                  </div>
                </div>
                <a href="{{ route('content.details', $featured->id_contenu) }}" class="explore-btn">
                  <span>Explorez</span>
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        @endif

        <!-- Actu & Tendances (3 contenus) -->
        <div class="col-lg-6">
          <div class="row g-3">
            @foreach($tendances as $index => $contenu)
            <div class="col-12" data-aos="fade-left" data-aos-delay="{{ 300 + ($index * 100) }}">
              <div class="compact-destination">
                <div class="destination-image">
                  @if($contenu->image)
                    <img src="{{ $contenu->image_url }}" alt="{{ $contenu->titre }}" class="img-fluid">
                  @else
                    <img src="{{ asset('assets/img/travel/default.jpg') }}" alt="{{ $contenu->titre }}" class="img-fluid">
                  @endif
                </div>
                <div class="destination-details">
                  <h4>{{ $contenu->titre }}</h4>
                  <p class="location"><i class="bi bi-geo-alt"></i> {{ $contenu->region->nom_region}}</p>
                  <p class="brief">{{ $contenu->excerpt }}</p>
                  <div class="stats-row">
                    <span class="tour-count"><i class="bi bi-calendar-check"></i> {{ $contenu->comment_count }} commentaire(s)</span>
                    <span class="rating"><i class="bi bi-star-fill"></i> {{ number_format($contenu->rating, 1) }}</span>
                  </div>
                  <a href="{{ route('content.details', $contenu->id_contenu) }}" class="quick-link">Voir Plus <i class="bi bi-chevron-right"></i></a>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Explorer Plus Section -->
  <section id="featured-tours" class="featured-tours section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Explorer Plus</h2>
        <div><span>Découvrez les contenus ajoutés</span> <span class="description-title">récemment</span></div>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          @foreach($recents as $index => $contenu)
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 200 + ($index * 100) }}">
            <div class="tour-card">
              <div class="tour-image">
                @if($contenu->image)
                  <img src="{{ $contenu->image_url }}" alt="{{ $contenu->titre }}" class="img-fluid" loading="lazy">
                @else
                  <img src="{{ asset('assets/img/travel/default.jpg') }}" alt="{{ $contenu->titre }}" class="img-fluid" loading="lazy">
                @endif
              </div>
              <div class="tour-content">
                <h4>{{ $contenu->titre }}</h4>
                <div class="tour-meta">
                  <span class="duration"><i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($contenu->date_creation)->locale('fr')->diffForHumans() }}</span>
                  <span class="group-size"><i class="bi bi-geo-alt"></i> {{ $contenu->region->nom_region}}</span>
                </div>
                <p>{{ $contenu->excerpt }}</p>
                <div class="tour-highlights">
                  @if($contenu->langue)
                    <span>{{ $contenu->langue->nom_langue }}</span>
                  @endif
                  @if($contenu->region)
                    <span>{{ $contenu->region->nom_region }}</span>
                  @endif
                </div>
                <div class="tour-action">
                  <a href="{{ route('content.details', $contenu->id_contenu) }}" class="btn-book">Voir Plus</a>
                  <div class="tour-rating">
                    @for($i = 1; $i <= 5; $i++)
                      @if($i <= floor($contenu->rating))
                        <i class="bi bi-star-fill"></i>
                      @elseif($i == ceil($contenu->rating) && fmod($contenu->rating, 1) > 0)
                        <i class="bi bi-star-half"></i>
                      @else
                        <i class="bi bi-star"></i>
                      @endif
                    @endfor
                    <span>{{ $contenu->formatted_rating }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Tour Item -->
          @endforeach
        </div>

        @if($recents->isEmpty())
        <div class="text-center mt-5">
          <p class="text-muted">Aucun contenu récent pour le moment. Soyez le premier à contribuer!</p>
          <a href="{{ route('contribute') }}" class="btn btn-primary">Contribuer</a>
        </div>
        @endif

        <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="500">
          <a href="{{ route('contenus') }}" class="btn-view-all">Voir Tout</a>
        </div>
      </div>
  </section><!-- /Featured Tours Section -->

  <!-- Testimonials Home Section -->
  <section id="testimonials-home" class="testimonials-home section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Notre Équipe de Modération</h2>
        <div><span>Des experts engagés pour </span> <span class="description-title">un contenu de qualité.</span></div>
      </div><!-- End Section Title -->

     <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 1,
                  "spaceBetween": 40
                },
                "1200": {
                  "slidesPerView": 3,
                  "spaceBetween": 1
                }
              }
            }
          </script>
          <div class="swiper-wrapper">

            @forelse($moderateurs as $moderateur)
            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Expert en modération culturelle, je veille à la qualité et l'authenticité des contenus partagés sur notre plateforme.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="{{ $moderateur->photo_url }}" class="testimonial-img" alt="{{ $moderateur->nom }} {{ $moderateur->prenom }}">
                <h3>{{ $moderateur->prenom }} {{ $moderateur->nom }}</h3>
                <h4>Modérateur</h4>
              </div>
            </div><!-- End testimonial item -->
            @empty
            <div class="swiper-slide">
              <div class="testimonial-item">
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Notre équipe de modération travaille avec passion pour garantir la qualité des contenus culturels.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
                <img src="{{ asset('assets/img/travel/default.jpeg') }}" class="testimonial-img" alt="Modérateur">
                <h3>Équipe de Modération</h3>
                <h4>Modérateur</h4>
              </div>
            </div><!-- End testimonial item -->
            @endforelse

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
          </script>
          
  </section><!-- /Testimonials Home Section -->

  <!-- Call To Action Section -->
  <section id="call-to-action" class="call-to-action section light-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="hero-content" data-aos="zoom-in" data-aos-delay="200">
          <div class="content-wrapper">
            <div class="badge-wrapper">
              <span class="promo-badge">Communauté Active</span>
            </div>
            <h2>Rejoignez le Mouvement de Préservation Culturelle</h2>
            <p>Ensemble, construisons la plus grande archive numérique du patrimoine béninois.</p>
            



            <div class="action-section">
              <div class="main-actions">
                <a href="{{ route('contenus') }}" class="btn btn-explore">
                  <i class="bi bi-compass"></i>
                   Découvrir
                </a>
                <a href="{{ route('contribute') }}" class="btn btn-deals">
                  <i class="bi bi-percent"></i>
                  Contribuer
                </a>
              </div>
            </div>
          </div>

          <div class="visual-element">
            <img src="{{ asset('assets/img/travel/Officiel, SigneBénin.jpg') }}" alt="Culture Bénin" class="hero-image" loading="lazy">
            <div class="image-overlay">
              <div class="stat-item">
                <span class="stat-number">{{ \App\Models\Contenu::count() }}+</span>
                <span class="stat-label">Contenus</span>
              </div>
              <div class="stat-item">
                <span class="stat-number">{{ \App\Models\Utilisateurs::count() }}+</span>
                <span class="stat-label">Membres</span>
              </div>
            </div>
          </div>
        </div>

        <div class="newsletter-section" data-aos="fade-up" data-aos-delay="300">
          <div class="newsletter-card">
            <div class="newsletter-content">
              <div class="newsletter-icon">
                <i class="bi bi-envelope-heart"></i>
              </div>
              <div class="newsletter-text">
                <h3>Restez Connecté </h3>
                <p>Recevez les dernières nouvelles et mises à jour directement dans votre boîte mail.</p>
              </div>
            </div>

            <form class="php-email-form newsletter-form" action="{{ route('newsletter.subscribe') }}" method="post">
              @csrf
              <div class="form-wrapper">
                <input type="email" name="email" class="email-input" placeholder="Votre adresse email" required>
                <button type="submit" class="subscribe-btn">
                  <i class="bi bi-arrow-right"></i>
                </button>
              </div>

              <div class="loading">Chargement...</div>
              @if ($errors->has('email'))
                <div class="error-message">{{ $errors->first('email') }}</div>
              @endif
              @if(session('success'))
                <div class="sent-message">{{ session('success') }}</div>
              @endif

              <div class="trust-indicators">
                <i class="bi bi-lock"></i>
                <span>Votre adresse reste confidentielle. Désabonnement possible à tout moment.</span>
              </div>
            </form>
          </div>
        </div>

        <div class="benefits-showcase" data-aos="fade-up" data-aos-delay="400">
          <div class="benefits-header">
            <h3>Ce que Nous Offrons</h3>
            <p>Une plateforme culturelle dédiée à la valorisation du patrimoine béninois.</p>
          </div>

          <div class="benefits-grid">
            <div class="benefit-card" data-aos="flip-left" data-aos-delay="450">
              <div class="benefit-visual">
                <div class="benefit-icon-wrap">
                  <i class="bi bi-collection"></i>
                </div>
                <div class="benefit-pattern"></div>
              </div>
              <div class="benefit-content">
                <h4>Collecte de Savoirs</h4>
                <p>Histoires, langues, recettes et traditions soigneusement répertoriées.</p>
              </div>
            </div>

            <div class="benefit-card" data-aos="flip-left" data-aos-delay="500">
              <div class="benefit-visual">
                <div class="benefit-icon-wrap">
                  <i class="bi bi-globe"></i>
                </div>
                <div class="benefit-pattern"></div>
              </div>
              <div class="benefit-content">
                <h4>Exploration Culturelle</h4>
                <p>Un accès simplifié aux régions, rites, légendes et héritages du Bénin.</p>
              </div>
            </div>

            <div class="benefit-card" data-aos="flip-left" data-aos-delay="550">
              <div class="benefit-visual">
                <div class="benefit-icon-wrap">
                  <i class="bi bi-people-fill"></i>
                </div>
                <div class="benefit-pattern"></div>
              </div>
              <div class="benefit-content">
                <h4>Transmission du Patrimoine</h4>
                <p>Des contenus pensés pour l'éducation, la recherche et la préservation culturelle.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialisation des compteurs
    if (typeof PureCounter !== 'undefined') {
      new PureCounter();
    }

    // Initialisation du swiper
    const swiperEl = document.querySelector('.init-swiper');
    if (swiperEl) {
      const swiperConfig = JSON.parse(swiperEl.querySelector('.swiper-config').textContent);
      new Swiper('.init-swiper', swiperConfig);
    }
  });
</script>
@endpush