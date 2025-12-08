@php
  $layout = (auth()->check() && (auth()->user()->id_role ?? null) == 3) ? 'Moderateur.layout' : 'frontend.app';
@endphp

@extends($layout)
@section('content')
<main class="main">

    <!-- Page Title -->
    <!-- <div class="page-title dark-background" data-aos="fade" style="background-image: url('{{ $content->image_url }}');"> -->
       <div class="page-title dark-background" data-aos="fade" style="background-color: #0ea2bd;">
      <div class="container position-relative">
        <h1>{{ $content->titre }}</h1>
        <p>{{ $content->excerpt }}</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('home') }}">Accueil</a></li>
            <li><a href="{{ route('contenus') }}">Contenus</a></li>
            <li class="current">{{ Str::limit($content->titre, 30) }}</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Travel Tour Details Section -->
    <section id="travel-tour-details" class="travel-tour-details section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <!-- Hero Section -->
       <!-- Hero Section -->
<!-- Hero Section -->
<div class="tour-hero">
  <div class="hero-image-wrapper">
    @if($content->has_video)
      @if($content->is_embed_video)
        <!-- Vidéo embed (YouTube, Vimeo) -->
        <div class="video-container">
          <iframe 
            src="{{ $content->video_url }}" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen>
          </iframe>
        </div>
      @else
        <!-- Vidéo uploadée -->
        <div class="video-container">
          <video 
            controls 
            preload="metadata"
            poster="{{ $content->video_poster }}"
            class="w-100"
            style="max-height: 600px;"
          >
            <source src="{{ $content->video_url }}" type="{{ $content->video_type }}">
            Votre navigateur ne supporte pas la lecture de vidéos.
          </video>
        </div>
      @endif
    @elseif($content->image)
      <!-- Image seulement -->
      <img src="{{ $content->image_url }}" alt="{{ $content->titre }}" class="img-fluid w-100">
    @else
      <!-- Image par défaut -->
      <img src="{{ asset('assets/img/travel/logo.png') }}" alt="{{ $content->titre }}" class="img-fluid w-100">
    @endif
    
    <!-- Debug info (optionnel, à retirer en production) -->
    <div style="position: absolute; bottom: 10px; left: 10px; background: rgba(0,0,0,0.7); color: white; padding: 5px; font-size: 12px; z-index: 100; display: none;">
      <strong>Debug:</strong><br>
      Video: {{ $content->video ?? 'Aucune' }}<br>
      URL: {{ $content->video_url ?? 'N/A' }}<br>
      Type: {{ $content->video_type ?? 'N/A' }}
    </div>
    
    <div class="hero-overlay">
      <div class="hero-content">
        <h1>{{ $content->titre }}</h1>
        <div class="hero-meta">
          @if($content->region)
            <span class="destination"><i class="bi bi-geo-alt"></i> {{ $content->region->nom_region }}</span>
          @endif
          @if($content->langue)
            <span class="language"><i class="bi bi-translate"></i> {{ $content->langue->nom_langue }}</span>
          @endif
          <span class="rating"><i class="bi bi-star-fill"></i> {{ $content->formatted_rating }}</span>
        </div>
        <p class="hero-tagline">{{ $content->excerpt }}</p>
      </div>
    </div>
  </div>
</div>

        <!-- Content Overview -->
        <div class="tour-overview" data-aos="fade-up" data-aos-delay="200">
          <div class="row">
            <div class="col-lg-8">
              <h2>Contenu</h2>
              <div class="content-text">
                @php
                  // Compter les mots du contenu
                  $wordCount = str_word_count(strip_tags($content->texte));
                  $wordLimit = 200; // Limite de mots avant afficher le paywall
                  $needsPayment = $wordCount > $wordLimit;
                  
                  // Si paiement effectué, afficher tout le contenu
                  $paidContents = session('paid_contents', []);
                  $hasPaid = in_array($content->id_contenu, $paidContents);
                @endphp
                
                @if($needsPayment && !$hasPaid)
                  {{-- Afficher un extrait du contenu --}}
                  @php
                    $words = preg_split('/\s+/', strip_tags($content->texte));
                    $excerpt = implode(' ', array_slice($words, 0, $wordLimit)) . '...';
                  @endphp
                  {!! nl2br(e($excerpt)) !!}
                  
                  <div class="paywall-cta" style="margin-top:20px; padding:15px; background:#f8f9fa; border-left:4px solid #f0ad4e; border-radius:4px;">
                    <p style="margin-bottom:12px; color:#666;">
                      <i class="bi bi-lock-fill" style="color:#f0ad4e; margin-right:8px;"></i>
                      <strong>Contenu protégé</strong> - {{ $wordCount }} mots disponibles
                    </p>
                    <button type="button" id="voirSuiteBtn" class="btn btn-primary" 
                            data-content-id="{{ $content->id_contenu }}"
                            style="background:#f0ad4e; border:none; padding:10px 18px; border-radius:6px; font-weight:500; cursor:pointer;">
                      <i class="bi bi-lock-fill" style="margin-right:6px;"></i>Lire la suite (100 XOF)
                    </button>
                    <small style="display:block; margin-top:10px; color:#999; font-size:0.85rem;">
                      <i class="bi bi-shield-check" style="margin-right:4px;"></i>Paiement sécurisé par FedaPay
                    </small>
                  </div>
                @else
                  {{-- Afficher le contenu complet --}}
                  {!! nl2br(e($content->texte)) !!}
                  
                  @if($hasPaid && $needsPayment)
                    <div style="margin-top:15px; padding:10px; background:#d4edda; border-left:4px solid #28a745; border-radius:4px;">
                      <small style="color:#155724;">
                        <i class="bi bi-check-circle-fill" style="margin-right:6px;"></i>
                        Merci pour votre paiement ! Vous avez accès au contenu complet.
                      </small>
                    </div>
                  @endif
                @endif
              </div>
              
              <!-- @if($content->region)
              <div class="region-info mt-4">
                <h4>Région: {{ $content->region->nom_region }}</h4>
                <p>{{ $content->region->description }}</p>
              </div>
              @endif -->
            </div>
            <div class="col-lg-4">
              <div class="tour-highlights">
                <h3>Informations</h3>
                <ul>
                  @if($content->auteur)
                  <li>
                    <i class="bi bi-person-circle"></i>
                    <div>
                      <strong>Auteur:</strong><br>
                      {{ $content->auteur->nom }} {{ $content->auteur->prenom }}
                    </div>
                  </li>
                  @endif
                  
                  @if($content->moderateur)
                  <li>
                    <i class="bi bi-shield-check"></i>
                    <div>
                      <strong>Modérateur:</strong><br>
                      {{ $content->moderateur->nom }} {{ $content->moderateur->prenom }}
                    </div>
                  </li>
                  @endif
                  
                  <li>
                    <i class="bi bi-calendar-event"></i>
                    <div>
                      <strong>Publié le:</strong><br>
                      {{ $content->formatted_date }}
                    </div>
                  </li>
                  
                  @if($content->langue)
                  <li>
                    <i class="bi bi-translate"></i>
                    <div>
                      <strong>Langue:</strong><br>
                      {{ $content->langue->nom_langue }}
                    </div>
                  </li>
                  @endif
                </ul>
                <div class="share-section mt-4">
                <h4>Partager ce contenu</h4>
                <div class="share-buttons">
                  <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" 
                     target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-facebook"></i> Facebook
                  </a>
                  <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $content->titre }}" 
                     target="_blank" class="btn btn-sm btn-outline-info">
                    <i class="bi bi-twitter"></i> Twitter
                  </a>
                  <a href="https://wa.me/?text={{ $content->titre }} {{ url()->current() }}" 
                     target="_blank" class="btn btn-sm btn-outline-success">
                    <i class="bi bi-whatsapp"></i> WhatsApp
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
              </div>
              
              <!-- Share Buttons -->
              

        <!-- Comments Section -->
        <div class="tour-itinerary" data-aos="fade-up" data-aos-delay="300">
          <h2>Commentaires ({{ $content->commentaires->count() }})</h2>
          
          @if($content->commentaires->isEmpty())
          <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Soyez le premier à commenter ce contenu !
          </div>
          @else
          <div class="itinerary-timeline">
            @foreach($content->commentaires->sortByDesc('date_creation') as $comment)
            <div class="itinerary-item">
              <div class="day-number">
                <img src="{{ $comment->user_photo }}" alt="{{ $comment->user_display_name }}" 
                     class="comment-avatar rounded-circle" width="60" height="60">
              </div>
              <div class="day-content">
                <h4>{{ $comment->user_display_name }}</h4>
                <p>{{ $comment->texte }}</p>
                <div class="day-details">
                  <span class="date"><i class="bi bi-clock"></i> {{ $comment->formatted_date }}</span>
                  @if($comment->email)
                  <span class="email"><i class="bi bi-envelope"></i> {{ $comment->email }}</span>
                  @endif
                </div>
              </div>
            </div>
            @endforeach
          </div>
          @endif
        </div>

        <!-- Comment Form -->
        <div class="booking-section" id="booking" data-aos="fade-up" data-aos-delay="400">
          <div class="booking-card">
            <h2>Ajouter un Commentaire</h2>
            <form action="{{ route('content.comment', $content->id_contenu) }}" method="post" class="php-email-form">
              @csrf
              
              @guest
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="name">Votre nom *</label>
                    <input type="text" name="name" id="name" class="form-control" required 
                           value="{{ old('name') }}" placeholder="Votre nom">
                    @error('name')
                      <div class="text-danger small">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="email">Votre email</label>
                    <input type="email" name="email" id="email" class="form-control" 
                           value="{{ old('email') }}" placeholder="email@exemple.com">
                    @error('email')
                      <div class="text-danger small">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
              @else
              <div class="alert alert-info">
                <i class="bi bi-person-circle"></i> Vous commentez en tant que 
                <strong>{{ auth()->user()->nom }} {{ auth()->user()->prenom }}</strong>
              </div>
              @endguest
              
              <div class="form-group">
                <label for="message">Votre message *</label>
                <textarea name="message" id="message" rows="4" class="form-control" 
                          required placeholder="Partagez vos impressions...">{{ old('message') }}</textarea>
                @error('message')
                  <div class="text-danger small">{{ $message }}</div>
                @enderror
              </div>
              
              @if(session('success'))
                <div class="alert alert-success">
                  <i class="bi bi-check-circle"></i> {{ session('success') }}
                </div>
              @endif
              
              @if($errors->any())
                <div class="alert alert-danger">
                  <i class="bi bi-exclamation-circle"></i> Veuillez corriger les erreurs ci-dessus.
                </div>
              @endif
              
              <button type="submit" class="btn-submit">
                <i class="bi bi-send"></i> Poster le Commentaire
              </button>
            </form>
          </div>
        </div>

        <!-- Similar Contents -->
        @if($similarContents->isNotEmpty())
        <div class="similar-contents" data-aos="fade-up" data-aos-delay="500">
          <h2>Contenus Similaires</h2>
          <div class="row">
            @foreach($similarContents as $similar)
            <div class="col-lg-4 col-md-6">
              <div class="similar-card">
                @if($similar->image)
                  <img src="{{ $similar->image_url }}" alt="{{ $similar->titre }}" class="img-fluid">
                @else
                  <img src="{{ asset('assets/img/travel/default.jpg') }}" alt="{{ $similar->titre }}" class="img-fluid">
                @endif
                <div class="similar-content">
                  <h4>{{ $similar->titre }}</h4>
                  <p class="location">
                    <i class="bi bi-geo-alt"></i> {{ $similar->region->nom_region }}
                  </p>
                  <p class="brief">{{ $similar->excerpt }}</p>
                  <div class="stats-row">
                    <span class="tour-count">
                      <i class="bi bi-chat"></i> {{ $similar->comment_count }}
                    </span>
                    <span class="rating">
                      <i class="bi bi-star-fill"></i> {{ number_format($similar->rating, 1) }}
                    </span>
                  </div>
                  <a href="{{ route('content.details', $similar->id_contenu) }}" class="btn-read">
                    Lire la suite <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
        @endif

        <!-- Final CTA -->
        <div class="final-cta" data-aos="fade-up" data-aos-delay="600">
          <div class="cta-content">
            <h2>Cet article vous a plu ?</h2>
            <p>Partagez-le avec vos amis ou découvrez d'autres contenus similaires.</p>
            <div class="cta-actions">
              <a href="{{ route('contenus') }}" class="btn-primary">
                <i class="bi bi-compass"></i> Explorer plus de contenus
              </a>
              <a href="javascript:void(0);" onclick="shareContent()" class="btn-secondary">
                <i class="bi bi-share"></i> Partager cet Article
              </a>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Travel Tour Details Section -->

  </main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  const btn = document.getElementById('voirSuiteBtn');
  if (!btn) return;
  btn.addEventListener('click', function(){
    btn.disabled = true;
    btn.innerText = 'Redirection vers le paiement...';
    fetch('{{ route('fedapay.pay') }}?content_id={{ $content->id_contenu }}')
      .then(res => res.json())
      .then(data => {
        if (data && data.payment_url) {
          window.location.href = data.payment_url;
        } else {
          alert('Impossible de démarrer le paiement.');
          btn.disabled = false;
          btn.innerText = 'Voir la suite (100 XOF)';
        }
      })
      .catch(err => {
        console.error(err);
        alert('Erreur lors de la demande de paiement.');
        btn.disabled = false;
        btn.innerText = 'Voir la suite (100 XOF)';
      });
  });
});
</script>
@endpush

@push('styles')
<style>
    .video-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 */
        height: 0;
        overflow: hidden;
        max-width: 100%;
        background: #000;
    }
    
    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    
    .comment-avatar {
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .similar-card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        margin-bottom: 30px;
    }
    
    .similar-card:hover {
        transform: translateY(-5px);
    }
    
    .similar-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    
    .similar-content {
        padding: 20px;
    }
    
    .btn-read {
        display: inline-block;
        color: #0ea2bd;
        text-decoration: none;
        font-weight: 500;
        margin-top: 10px;
    }
    
    .btn-read:hover {
        color: #0d8b9e;
    }
    
    .share-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .content-text {
        line-height: 1.8;
        font-size: 1.1rem;
        color: #333;
    }
    
    .content-text p {
        margin-bottom: 1.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    function shareContent() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $content->titre }}',
                text: '{{ $content->excerpt }}',
                url: '{{ url()->current() }}'
            })
            .then(() => console.log('Contenu partagé avec succès'))
            .catch(error => console.log('Erreur de partage:', error));
        } else {
            // Fallback pour les navigateurs qui ne supportent pas l'API Web Share
            alert('Copiez ce lien pour partager: ' + window.location.href);
        }
    }
    
    // Affichage des messages d'erreur/succès
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            setTimeout(() => {
                document.querySelector('.alert-success')?.remove();
            }, 5000);
        @endif
        
        // Mise en forme des URLs dans les commentaires
        const commentTexts = document.querySelectorAll('.day-content p');
        commentTexts.forEach(text => {
            text.innerHTML = text.innerHTML.replace(
                /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gi,
                '<a href="$1" target="_blank" rel="nofollow">$1</a>'
            );
        });
        
        // Gestion du paiement pour contenu restreint
        const voirSuiteBtn = document.getElementById('voirSuiteBtn');
        if (voirSuiteBtn) {
            voirSuiteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                const contentId = this.getAttribute('data-content-id');
                
                // Rediriger vers la page de confirmation de paiement
                window.location.href = '{{ route("payment.confirmation") }}?content_id=' + contentId;
            });
        }
    });
</script>
@endpush