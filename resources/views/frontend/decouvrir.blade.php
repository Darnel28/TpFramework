@extends('frontend.app')
@section('content')
<div class="slider">
  <!-- CONTENEUR DES SLIDES HORIZONTAUX -->
  <div class="slides-container" id="slidesContainer">
    @foreach($contenus as $index => $contenu)
    <div class="slide {{ $index === 0 ? 'active' : '' }}" style="background-image:url('{{ $contenu->image ?? asset('assets/img/travel/default.jpg') }}')">
      <div class="slide-overlay"></div>
      <div class="slide-content">
        <div class="slide-location">
          <i class="bi bi-geo-alt"></i>
          {{ $contenu->region->nom_region ?? 'Bénin' }}
        </div>
        <h1 class="slide-title">{{ $contenu->titre }}</h1>
        <p class="slide-description">{{ Str::limit(strip_tags($contenu->texte ?? ''), 200) }}</p>
        <div class="slide-meta">
          @if($contenu->langue)
          <span class="meta-badge">
            <i class="bi bi-translate"></i>
            {{ $contenu->langue->nom_langue }}
          </span>
          @endif
          @if($contenu->region)
          <span class="meta-badge">
            <i class="bi bi-geo-alt"></i>
            {{ $contenu->region->nom_region }}
          </span>
          @endif
        </div>
        <a href="{{ isset($contenu->id_contenu) ? route('content.details', $contenu->id_contenu) : '#' }}" class="btn-explore">
          <span>Découvrir</span>
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>
    </div>
    @endforeach
  </div>

  <!-- VIGNETTES DÉBORDANTES À DROITE -->
  <div class="cards-container" id="cardsContainer">
    @foreach($contenus as $index => $contenu)
    <div class="card {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
      <img src="{{ $contenu->image ?? asset('assets/img/travel/default.jpg') }}" alt="{{ $contenu->titre }}">
      <div class="card-title-overlay">{{ Str::limit($contenu->titre, 20) }}</div>
    </div>
    @endforeach
  </div>

  <!-- BARRE DE PROGRESSION VERTICALE -->
  <div class="progress-container">
    <div class="progress-bar" id="progressBar"></div>
  </div>

  <!-- PAGINATION VERTICALE -->
  <div class="pagination" id="pagination">
    @foreach($contenus as $index => $contenu)
    <div class="pagination-dot {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"></div>
    @endforeach
  </div>

  <!-- COMPTEUR -->
  <div class="slide-counter">
    <span id="currentSlide">1</span>/<span id="totalSlides">{{ count($contenus) }}</span>
  </div>

  <!-- BOUTON POUR AFFICHER/CACHER LES VIGNETTES -->
  <button class="toggle-cards-btn" id="toggleCardsBtn">
    <i class="bi bi-chevron-left"></i>
  </button>

  <!-- BOUTONS DE NAVIGATION -->
  <button class="nav-btn prev-btn" id="prevBtn">
    <i class="bi bi-chevron-left"></i>
  </button>
  <button class="nav-btn next-btn" id="nextBtn">
    <i class="bi bi-chevron-right"></i>
  </button>
</div>
@endsection

@push('styles')
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body, html {
    overflow-x: hidden;
  }

  /* CONTAINER PRINCIPAL */
  .slider {
    position: relative;
    width: 100%;
    height: 100vh;
    overflow: hidden;
    background: #0a0a0a;
  }

  /* CONTENEUR DES IMAGES FULLSCREEN EN HORIZONTAL */
  .slides-container {
    position: absolute;
    top: 0;
    left: 0;
    width: {{ max(count($contenus), 1) * 100 }}%;
    height: 100%;
    display: flex;
    transition: transform 1s cubic-bezier(0.4, 0, 0.2, 1);
  }

  /* IMAGE FULLSCREEN */
  .slide {
    width: 100vw;
    height: 100vh;
    background-size: cover;
    background-position: center;
    position: relative;
    flex-shrink: 0;
    transform-origin: center center;
  }

  /* EFFET DE SAUT POUR LA NOUVELLE IMAGE */
  .slide.jumping-in {
    animation: jumpFromThumbnail 1s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
    z-index: 20;
  }

  /* EFFET DE SORTIE POUR L'ANCIENNE IMAGE */
  .slide.jumping-out {
    animation: jumpOut 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    z-index: 10;
  }

  @keyframes jumpFromThumbnail {
    0% {
      transform: scale(0.1) translate(100vw, 50vh);
      opacity: 0;
      border-radius: 20px;
      box-shadow: 0 0 0 rgba(0, 0, 0, 0);
    }
    30% {
      transform: scale(0.3) translate(70vw, 20vh);
      opacity: 0.5;
      border-radius: 15px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }
    50% {
      transform: scale(0.6) translate(40vw, -10vh);
      opacity: 0.8;
      border-radius: 10px;
      box-shadow: 0 40px 80px rgba(0, 0, 0, 0.7);
    }
    70% {
      transform: scale(0.9) translate(20vw, 5vh);
      opacity: 0.9;
      border-radius: 5px;
      box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6);
    }
    100% {
      transform: scale(1) translate(0, 0);
      opacity: 1;
      border-radius: 0;
      box-shadow: 0 0 0 rgba(0, 0, 0, 0);
    }
  }

  @keyframes jumpOut {
    0% {
      transform: scale(1) translate(0, 0);
      opacity: 1;
    }
    100% {
      transform: scale(0.8) translate(-30vw, 0);
      opacity: 0;
    }
  }

  /* OVERLAY POUR CHAQUE IMAGE */
  .slide-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.7) 100%);
  }

  /* CONTENU SUR CHAQUE SLIDE */
  .slide-content {
    position: absolute;
    top: 50%;
    left: 10%;
    transform: translateY(-50%);
    color: white;
    max-width: 600px;
    z-index: 2;
    opacity: 0;
    transition: opacity 0.8s ease 0.5s;
  }

  .slide.active .slide-content {
    opacity: 1;
  }

  .slide-location {
    font-size: 14px;
    color: #0ea2bd;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .slide-title {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 20px;
    text-shadow: 0 4px 12px rgba(0, 0, 0, 0.8);
    line-height: 1.1;
    text-transform: uppercase;
  }

  .slide-description {
    font-size: 1.2rem;
    opacity: 0.9;
    line-height: 1.6;
    margin-bottom: 25px;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.8);
  }

  .slide-meta {
    display: flex;
    gap: 15px;
    margin-bottom: 30px;
  }

  .meta-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 255, 255, 0.1);
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
  }

  .meta-badge i {
    color: #0ea2bd;
  }

  .btn-explore {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 18px 40px;
    background: linear-gradient(135deg, #0ea2bd 0%, #0d8b9e 100%);
    color: #fff;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(14, 162, 189, 0.3);
  }

  .btn-explore:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(14, 162, 189, 0.4);
    color: #fff;
  }

  .btn-explore i {
    transition: transform 0.3s ease;
  }

  .btn-explore:hover i {
    transform: translateX(5px);
  }

  /* CONTENEUR DES VIGNETTES - DÉBORDANT DE L'ÉCRAN À DROITE */
  .cards-container {
    position: absolute;
    bottom: 5%;
    right: -80px;
    display: flex;
    gap: 20px;
    z-index: 30;
    padding: 15px 40px 15px 100px;
    border-radius: 20px 0 0 20px;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-right: none;
    box-shadow: -10px 0 30px rgba(0, 0, 0, 0.5);
    transform: translateX(0);
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    max-width: 85vw;
    overflow: hidden;
  }

  .cards-container.hidden {
    transform: translateX(calc(100% - 100px));
  }

  /* VIGNETTES */
  .card {
    width: 130px;
    height: 180px;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.7);
    border: 2px solid transparent;
    opacity: 0.7;
    flex-shrink: 0;
    transform-origin: center;
  }

  .card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
  }

  .card-title-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 10px;
    background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
    color: white;
    font-size: 11px;
    font-weight: 600;
    text-align: center;
  }

  .card:hover {
    transform: translateY(-10px) scale(1.05);
    opacity: 1;
    border-color: rgba(14, 162, 189, 0.6);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.8);
    z-index: 5;
  }

  .card:hover img {
    transform: scale(1.1);
  }

  .card.active {
    border-color: #0ea2bd;
    opacity: 1;
    box-shadow: 0 0 20px rgba(14, 162, 189, 0.5);
  }

  .card.clicked {
    animation: thumbnailClickEffect 0.5s ease forwards;
  }

  @keyframes thumbnailClickEffect {
    0% {
      transform: scale(1);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.7);
    }
    50% {
      transform: scale(0.9);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
    }
    100% {
      transform: scale(1);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.7);
    }
  }

  /* BARRE DE PROGRESSION VERTICALE */
  .progress-container {
    position: absolute;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
    width: 3px;
    height: 300px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 3px;
    overflow: hidden;
    z-index: 25;
  }

  .progress-bar {
    width: 100%;
    height: {{ max(count($contenus), 1) > 0 ? (100 / max(count($contenus), 1)) : 10 }}%;
    background: #0ea2bd;
    border-radius: 3px;
    transition: transform 1s cubic-bezier(0.4, 0, 0.2, 1);
  }

  /* NUMÉRO DE SLIDE */
  .slide-counter {
    position: absolute;
    top: 5%;
    right: 5%;
    color: white;
    font-size: 1.2rem;
    font-weight: 600;
    z-index: 25;
    background: rgba(0, 0, 0, 0.5);
    padding: 15px;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(5px);
    border: 2px solid rgba(14, 162, 189, 0.3);
  }

  /* BOUTONS DE NAVIGATION */
  .nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.15);
    border: none;
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    font-size: 1.8rem;
    cursor: pointer;
    z-index: 25;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.7;
  }

  .nav-btn:hover {
    background: rgba(14, 162, 189, 0.5);
    opacity: 1;
    transform: translateY(-50%) scale(1.1);
  }

  .nav-btn:active {
    transform: translateY(-50%) scale(0.95);
  }

  .prev-btn {
    left: 30px;
  }

  .next-btn {
    right: 30px;
  }

  /* PAGINATION VERTICALE */
  .pagination {
    position: absolute;
    left: 30px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    flex-direction: column;
    gap: 15px;
    z-index: 25;
  }

  .pagination-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .pagination-dot.active {
    background: #0ea2bd;
    transform: scale(1.3);
    box-shadow: 0 0 10px rgba(14, 162, 189, 0.5);
  }

  /* BOUTON TOGGLE */
  .toggle-cards-btn {
    position: absolute;
    bottom: 5%;
    right: 20px;
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    font-size: 1.5rem;
    cursor: pointer;
    z-index: 35;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .toggle-cards-btn:hover {
    background: rgba(14, 162, 189, 0.5);
    transform: scale(1.1);
  }

  .toggle-cards-btn.hidden i {
    transform: rotate(180deg);
  }

  /* RESPONSIVE */
  @media (max-width: 1024px) {
    .cards-container {
      right: -100px;
      max-width: 90vw;
      padding: 12px 30px 12px 80px;
      gap: 15px;
    }
    
    .card {
      width: 110px;
      height: 150px;
    }
    
    .slide-content {
      left: 5%;
      max-width: 500px;
    }
  }
  
  @media (max-width: 768px) {
    .cards-container {
      right: -120px;
      max-width: 95vw;
      padding: 10px 25px 10px 70px;
      gap: 12px;
    }
    
    .card {
      width: 90px;
      height: 130px;
    }
    
    .slide-title {
      font-size: 2.5rem;
    }
    
    .slide-description {
      font-size: 1rem;
    }
    
    .slide-content {
      max-width: 90%;
    }
    
    .nav-btn {
      width: 50px;
      height: 50px;
      font-size: 1.5rem;
    }
    
    .prev-btn {
      left: 15px;
    }
    
    .next-btn {
      right: 15px;
    }
  }
  
  @media (max-width: 480px) {
    .cards-container {
      right: -150px;
      padding: 8px 20px 8px 60px;
      gap: 10px;
    }
    
    .card {
      width: 70px;
      height: 100px;
    }
    
    .slide-title {
      font-size: 2rem;
    }
    
    .toggle-cards-btn {
      bottom: 10%;
      right: 10px;
      width: 40px;
      height: 40px;
    }
  }
</style>
@endpush

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const slidesContainer = document.querySelector('.slides-container');
    const slides = document.querySelectorAll('.slide');
    const cards = document.querySelectorAll('.card');
    const progressBar = document.querySelector('.progress-bar');
    const slideCounter = document.querySelector('.slide-counter');
    const paginationDots = document.querySelectorAll('.pagination-dot');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const toggleBtn = document.querySelector('.toggle-cards-btn');
    const cardsContainer = document.querySelector('.cards-container');
    
    let currentIndex = 0;
    const totalSlides = slides.length;
    let autoSlideInterval;
    let isTransitioning = false;

    // FONCTION : ALLER À UNE SLIDE AVEC ANIMATION DE SAUT DEPUIS LA VIGNETTE
    function goToSlideWithJump(index) {
      if (isTransitioning || index === currentIndex || index < 0 || index >= totalSlides) return;
      isTransitioning = true;

      const oldSlide = slides[currentIndex];
      const newSlide = slides[index];
      const clickedCard = cards[index];
      const sliderRect = document.querySelector('.slider').getBoundingClientRect();
      const cardRect = clickedCard.getBoundingClientRect();

      const dx = cardRect.left + cardRect.width / 2 - (sliderRect.left + sliderRect.width / 2);
      const dy = cardRect.top + cardRect.height / 2 - (sliderRect.top + sliderRect.height / 2);
      const scale = Math.max(0.25, Math.min(0.7, cardRect.width / sliderRect.width));

      // Placer la slide cible sous la vignette (sans transition)
      const previousContainerTransition = slidesContainer.style.transition;
      slidesContainer.style.transition = 'none';
      slidesContainer.style.transform = `translateX(-${index * 100}vw)`;

      newSlide.style.transition = 'none';
      newSlide.style.transform = `translate(${dx}px, ${dy}px) scale(${scale})`;
      newSlide.style.opacity = '0.3';

      // Effet clic vignette
      clickedCard.classList.add('clicked');

      // Forcer le reflow puis lancer l'animation vers le plein écran
      requestAnimationFrame(() => {
        requestAnimationFrame(() => {
          oldSlide.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
          oldSlide.style.opacity = '0';
          oldSlide.style.transform = 'scale(0.92)';

          newSlide.style.transition = 'transform 0.9s cubic-bezier(0.68, -0.55, 0.265, 1.55), opacity 0.9s ease';
          newSlide.style.transform = 'translate(0, 0) scale(1)';
          newSlide.style.opacity = '1';
        });
      });

      // Mettre à jour les états et nettoyer
      setTimeout(() => {
        currentIndex = index;
        updateSlider();

        // Nettoyage des styles inline
        newSlide.style.transition = '';
        newSlide.style.transform = '';
        newSlide.style.opacity = '';
        oldSlide.style.transition = '';
        oldSlide.style.transform = '';
        oldSlide.style.opacity = '';
        slidesContainer.style.transition = previousContainerTransition || '';
        clickedCard.classList.remove('clicked');
        isTransitioning = false;
      }, 950);
    }

    // FONCTION : ALLER À UNE SLIDE (NAVIGATION NORMALE)
    function goToSlide(index) {
      if (isTransitioning || index < 0 || index >= totalSlides) return;
      
      isTransitioning = true;
      currentIndex = index;
      updateSlider();
      
      setTimeout(() => {
        isTransitioning = false;
      }, 1000);
    }

    // FONCTION : METTRE À JOUR L'AFFICHAGE DU SLIDER
    function updateSlider() {
      // Déplacer les slides
      const translateValue = -(currentIndex * 100);
      slidesContainer.style.transform = `translateX(${translateValue}vw)`;
      
      // Mettre à jour les classes actives
      slides.forEach((slide, idx) => {
        slide.classList.toggle('active', idx === currentIndex);
      });
      
      cards.forEach((card, idx) => {
        card.classList.toggle('active', idx === currentIndex);
      });
      
      paginationDots.forEach((dot, idx) => {
        dot.classList.toggle('active', idx === currentIndex);
      });
      
      // Mettre à jour la barre de progression
      const progressPercentage = totalSlides > 1 ? ((currentIndex / (totalSlides - 1)) * 100) : 0;
      progressBar.style.transform = `translateY(${progressPercentage}%)`;
      
      // Mettre à jour le compteur
      slideCounter.textContent = `${currentIndex + 1}/${totalSlides}`;
      
      // Réinitialiser l'auto-slide
      resetAutoSlide();
    }

    // FONCTION : TOGGLE VISIBILITÉ DES VIGNETTES
    function toggleCardsVisibility() {
      cardsContainer.classList.toggle('hidden');
      toggleBtn.classList.toggle('hidden');
    }

    // FONCTION : AUTO-SLIDE
    function startAutoSlide() {
      autoSlideInterval = setInterval(() => {
        const nextIndex = (currentIndex + 1) % totalSlides;
        goToSlide(nextIndex);
      }, 5000);
    }

    function resetAutoSlide() {
      clearInterval(autoSlideInterval);
      startAutoSlide();
    }

    // ÉVÉNEMENTS : CLIC SUR LES VIGNETTES
    cards.forEach((card, index) => {
      card.addEventListener('click', () => {
        goToSlideWithJump(index);
      });
    });

    // ÉVÉNEMENTS : CLIC SUR LES POINTS DE PAGINATION
    paginationDots.forEach((dot, index) => {
      dot.addEventListener('click', () => {
        goToSlide(index);
      });
    });

    // ÉVÉNEMENTS : BOUTONS DE NAVIGATION
    prevBtn.addEventListener('click', () => {
      const prevIndex = (currentIndex - 1 + totalSlides) % totalSlides;
      goToSlide(prevIndex);
    });

    nextBtn.addEventListener('click', () => {
      const nextIndex = (currentIndex + 1) % totalSlides;
      goToSlide(nextIndex);
    });

    // ÉVÉNEMENT : TOGGLE BOUTON
    toggleBtn.addEventListener('click', toggleCardsVisibility);

    // ÉVÉNEMENTS : NAVIGATION AU CLAVIER
    document.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowLeft') {
        const prevIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        goToSlide(prevIndex);
      } else if (e.key === 'ArrowRight' || e.key === ' ') {
        e.preventDefault();
        const nextIndex = (currentIndex + 1) % totalSlides;
        goToSlide(nextIndex);
      }
    });

    // ÉVÉNEMENTS : SWIPE TACTILE (MOBILE)
    let touchStartX = 0;
    let touchEndX = 0;

    slidesContainer.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    slidesContainer.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();
    }, { passive: true });

    function handleSwipe() {
      const swipeThreshold = 50;
      const diff = touchStartX - touchEndX;

      if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
          // Swipe gauche (suivant)
          const nextIndex = (currentIndex + 1) % totalSlides;
          goToSlide(nextIndex);
        } else {
          // Swipe droite (précédent)
          const prevIndex = (currentIndex - 1 + totalSlides) % totalSlides;
          goToSlide(prevIndex);
        }
      }
    }

    // INITIALISATION
    updateSlider();
    startAutoSlide();
  });
</script>
@endpush