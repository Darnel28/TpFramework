@extends('frontend.app')

@section('title', 'Contribuer - Culture Bénin')
@section('description', 'Partagez vos connaissances et contribuez à la préservation du patrimoine culturel béninois')

@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background: linear-gradient(135deg, #0ea2bd 0%, #0b8ca3 100%);">
      <div class="container position-relative">
        <h1>Contribuer au Patrimoine Culturel</h1>
        <p>Partagez vos connaissances, histoires et traditions pour enrichir notre archive culturelle.</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('home') }}">Accueil</a></li>
            <li class="current">Contribuer</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Contribution Section -->
    <section id="contribute" class="contribute section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        
        <div class="row mb-5">
          <div class="col-lg-8 mx-auto text-center">
            <h2>Partagez Votre Savoir Culturel</h2>
            <p class="lead">Votre contribution aide à préserver et à transmettre le riche patrimoine culturel du Bénin aux générations futures.</p>
          </div>
        </div>

        <!-- Étape 1 : Vérification rapide -->
        @if(!auth()->check())
        <div class="row">
          <div class="col-lg-6 mx-auto">
            <div class="verification-card" id="verification-step">
              <div class="verification-header">
                <h3><i class="bi bi-shield-lock me-2"></i> Accès requis</h3>
                <p>Vérifiez votre identité pour continuer</p>
              </div>
              
              <form id="quick-verify-form">
                @csrf
                
                <div class="alert alert-info">
                  <i class="bi bi-info-circle me-2"></i>
                  Vous devez être connecté pour soumettre une contribution.
                </div>
                
                <div class="mb-3">
                  <label for="quick_email" class="form-label">Adresse Email <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="quick_email" name="email" required>
                </div>
                
                <div class="mb-3">
                  <label for="quick_password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                  <input type="password" class="form-control" id="quick_password" name="password" required>
                </div>
                
                <div class="mb-4">
                  <button type="submit" class="btn btn-primary w-100" id="verify-btn">
                    <i class="bi bi-key me-2"></i> Vérifier et continuer
                  </button>
                </div>
                
                <div class="text-center">
                  <p class="mb-2">Vous n'avez pas encore de compte ?</p>
                  <button type="button" class="btn btn-outline-primary" id="show-register-btn">
                    <i class="bi bi-person-plus me-2"></i> Créer un compte
                  </button>
                </div>
              </form>
            </div>

            <!-- Formulaire d'inscription rapide (caché par défaut) - version contributeur -->
            <div class="auth-card" id="quick-register-step" style="display: none; max-width: 720px; margin: 30px auto;">
              <div class="auth-header">
                <h3><i class="bi bi-person-plus me-2"></i> Création de compte contributeur</h3>
                <p>Créez un compte pour pouvoir contribuer au patrimoine culturel.</p>
              </div>

              <?php
                // Récupère les langues si la variable n'a pas été fournie par le controller
                try {
                  $regLangues = isset($langues) ? $langues : \App\Models\Langue::all();
                } catch (\Throwable $e) {
                  $regLangues = collect();
                }
              ?>

              <form id="quick-register-form" enctype="multipart/form-data" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Hidden full name field to satisfy backend validation expecting 'name' -->
                <input type="hidden" id="register_name" name="name" value="{{ old('name') }}">

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="register_nom" class="form-label">Nom <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="register_nom" name="nom" value="{{ old('nom') }}" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="register_prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="register_prenom" name="prenom" value="{{ old('prenom') }}" required>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12 mb-3">
                    <label for="register_email" class="form-label">Adresse Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="register_email" name="email" value="{{ old('email') }}" required>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="register_password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="register_password" name="password" required>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="register_password_confirmation" class="form-label">Confirmation du mot de passe <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="register_password_confirmation" name="password_confirmation" required>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="sexe" class="form-label">Sexe <span class="text-danger">*</span></label>
                    <select class="form-select" id="sexe" name="sexe" required>
                      <option value="">Sélectionnez</option>
                      <option value="M" {{ old('sexe')=='M' ? 'selected' : '' }}>Masculin</option>
                      <option value="F" {{ old('sexe')=='F' ? 'selected' : '' }}>Féminin</option>
                      
                    </select>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="date_naissance" class="form-label">Date de naissance</label>
                    <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="photo" class="form-label">Photo de profil</label>
                    <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                    <small class="text-muted">Format JPG/PNG, max 5MB</small>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="id_langue" class="form-label">Langue principale</label>
                    <select class="form-select" id="id_langue" name="id_langue">
                      <option value="">Sélectionnez une langue</option>
                      @foreach($regLangues as $langue)
                        <option value="{{ $langue->id_langue ?? $langue->id }}" {{ old('id_langue') == ($langue->id_langue ?? $langue->id) ? 'selected' : '' }}>
                          {{ $langue->nom_langue ?? $langue->name ?? $langue->nom }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-check mb-3">
                  <input class="form-check-input" type="checkbox" id="register_terms" name="terms" required>
                  <label class="form-check-label" for="register_terms">J'accepte les <a href="#" class="text-primary">conditions</a></label>
                </div>

                <div class="d-flex gap-3">
                  <button type="button" class="btn btn-outline-secondary w-50" id="back-to-login-btn">
                    <i class="bi bi-arrow-left me-2"></i> Retour
                  </button>
                  <button type="submit" class="btn btn-primary w-50" id="register-btn">
                    <i class="bi bi-check-circle me-2"></i> S'inscrire
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        @endif

        <!-- Étape 2 : Formulaire de contribution (visible après connexion) -->
        @if(auth()->check())
        <div class="row mt-5" id="contribution-form">
          <div class="col-lg-10 mx-auto">
            <div class="contribution-card">
              <div class="contribution-header">
                <h3><i class="bi bi-journal-plus me-2"></i> Ajouter un nouveau contenu</h3>
                <p>Partagez une histoire, une tradition, une recette ou une pratique culturelle</p>
              </div>
              
              <form method="POST" action="{{ route('contribute.submit') }}" id="contribution-form" enctype="multipart/form-data">
                @csrf
                
                @if(session('success'))
                <div class="alert alert-success">
                  {{ session('success') }}
                </div>
                @endif
                
                @if($errors->any())
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
                @endif
                
                <!-- Basic Information -->
                <div class="section-title mb-4">
                  <h4><i class="bi bi-info-circle me-2"></i> Informations de base</h4>
                </div>
                
                <div class="row mb-4">
                  <div class="col-md-12 mb-3">
                    <label for="titre" class="form-label">Titre du contenu <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre') }}" required placeholder="Ex: Recette de sauce gombo">
                    @error('titre')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                
                <div class="row mb-4">
                  <div class="col-md-6 mb-3">
                    <label for="id_region" class="form-label">Région <span class="text-danger">*</span></label>
                    <select class="form-select @error('id_region') is-invalid @enderror" id="id_region" name="id_region" required>
                      <option value="">Sélectionnez une région</option>
                      @foreach($regions as $region)
                        <option value="{{ $region->id_region }}" {{ old('id_region') == $region->id_region ? 'selected' : '' }}>
                          {{ $region->nom_region }}
                        </option>
                      @endforeach
                    </select>
                    @error('id_region')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
                  <div class="col-md-6 mb-3">
                    <label for="id_langue" class="form-label">Langue principale <span class="text-danger">*</span></label>
                    <select class="form-select @error('id_langue') is-invalid @enderror" id="id_langue" name="id_langue" required>
                      <option value="">Sélectionnez une langue</option>
                      @foreach($langues as $langue)
                        <option value="{{ $langue->id_langue }}" {{ old('id_langue') == $langue->id_langue ? 'selected' : '' }}>
                          {{ $langue->nom_langue }}
                        </option>
                      @endforeach
                    </select>
                    @error('id_langue')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                
                <div class="row mb-4">
                  <div class="col-md-6 mb-3">
                    <label for="id_type_contenu" class="form-label">Type de contenu <span class="text-danger">*</span></label>
                    <select class="form-select @error('id_type_contenu') is-invalid @enderror" id="id_type_contenu" name="id_type_contenu" required>
                      <option value="">Sélectionnez un type</option>
                      @if(isset($typecontenus) && $typecontenus->isNotEmpty())
                        @foreach($typecontenus as $type)
                          <option value="{{ $type->id_type_contenu ?? $type->id }}" {{ old('id_type_contenu') == ($type->id_type_contenu ?? $type->id) ? 'selected' : '' }}>
                            {{ $type->nom_contenu ?? $type->name ?? 'Type #' . ($type->id_type_contenu ?? $type->id) }}
                          </option>
                        @endforeach
                      @else
                        <!-- Fallback to previous hardcoded list if table empty -->
                        <option value="1" {{ old('id_type_contenu') == '1' ? 'selected' : '' }}>Histoire/Conte</option>
                        <option value="2" {{ old('id_type_contenu') == '2' ? 'selected' : '' }}>Recette culinaire</option>
                        <option value="3" {{ old('id_type_contenu') == '3' ? 'selected' : '' }}>Danse/Tradition</option>
                        <option value="4" {{ old('id_type_contenu') == '4' ? 'selected' : '' }}>Musique/Chant</option>
                        <option value="5" {{ old('id_type_contenu') == '5' ? 'selected' : '' }}>Artisanat</option>
                        <option value="6" {{ old('id_type_contenu') == '6' ? 'selected' : '' }}>Rite/Coutume</option>
                        <option value="7" {{ old('id_type_contenu') == '7' ? 'selected' : '' }}>Savoir traditionnel</option>
                      @endif
                    </select>
                    @error('id_type_contenu')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Ce contenu est :</label>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="content_type" id="original" value="original" {{ old('content_type', 'original') == 'original' ? 'checked' : '' }}>
                      <label class="form-check-label" for="original">
                        Un contenu original
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="content_type" id="translation" value="translation" {{ old('content_type') == 'translation' ? 'checked' : '' }}>
                      <label class="form-check-label" for="translation">
                        Une traduction d'un contenu existant
                      </label>
                    </div>
                    <!-- Sélecteur du contenu parent (affiché si traduction) -->
                    <div id="parent-select-row" class="mt-3" style="display: none;">
                      <label for="parent_id" class="form-label">Contenu original à traduire <span class="text-danger">*</span></label>
                      <select class="form-select" id="parent_id" name="parent_id">
                        <option value="">Sélectionnez le contenu original</option>
                        @isset($originals)
                          @foreach($originals as $orig)
                            <option value="{{ $orig->id_contenu }}">{{ $orig->titre }}</option>
                          @endforeach
                        @endisset
                      </select>
                    </div>
                  </div>
                </div>
                
                <!-- Content Section -->
                <div class="section-title mb-4">
                  <h4><i class="bi bi-journal-text me-2"></i> Contenu</h4>
                </div>
                
                <div class="row mb-4">
                  <div class="col-md-12 mb-3">
                    <label for="texte" class="form-label">Texte du contenu <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('texte') is-invalid @enderror" id="texte" name="texte" rows="8" required placeholder="Rédigez votre contenu ici...">{{ old('texte') }}</textarea>
                    <small class="text-muted">Vous pouvez utiliser des paragraphes, des listes, etc.</small>
                    @error('texte')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                
                <!-- Media Section -->
                <div class="section-title mb-4">
                  <h4><i class="bi bi-images me-2"></i> Médias (optionnel)</h4>
                </div>
                
                <div class="row mb-4">
                  <div class="col-md-6 mb-3">
                    <label for="image" class="form-label">Image illustrative</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                    <small class="text-muted">Formats acceptés: JPG, PNG, GIF (max 5MB)</small>
                    @error('image')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  
                  <div class="col-md-6 mb-3">
                    <label for="video" class="form-label">Lien vidéo (YouTube, Vimeo)</label>
                    <input type="url" class="form-control @error('video') is-invalid @enderror" id="video" name="video" value="{{ old('video') }}" placeholder="https://youtube.com/watch?v=...">
                    <small class="text-muted">Collez le lien direct de la vidéo</small>
                    @error('video')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                
                <!-- Submission -->
                <div class="contribution-footer">
                  <div class="form-check mb-4">
                    <input class="form-check-input @error('agree_terms') is-invalid @enderror" type="checkbox" id="agree_terms" name="agree_terms" required {{ old('agree_terms') ? 'checked' : '' }}>
                    <label class="form-check-label" for="agree_terms">
                      Je certifie que ce contenu est authentique et respecte les valeurs culturelles béninoises.
                    </label>
                    @error('agree_terms')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                  </div>
                  
                  <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Important :</strong> Votre contribution sera soumise à modération avant publication. 
                    Vous recevrez une notification une fois votre contenu validé.
                  </div>
                  
                  <div class="d-flex justify-content-between mt-4">
                    <button type="reset" class="btn btn-outline-secondary">
                      <i class="bi bi-arrow-clockwise me-2"></i> Réinitialiser
                    </button>
                    <button type="submit" class="btn btn-primary">
                      <i class="bi bi-send me-2"></i> Soumettre la contribution
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        @endif

      </div>
    </section><!-- /Contribution Section -->

    <!-- Benefits Section -->
    <section class="benefits section light-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center mb-5">
            <h2>Pourquoi Contribuer ?</h2>
            <p>Votre contribution a un impact significatif sur la préservation culturelle</p>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
            <div class="benefit-item">
              <div class="benefit-icon">
                <i class="bi bi-archive"></i>
              </div>
              <h4>Préservation</h4>
              <p>Aidez à sauvegarder les traditions et savoirs avant qu'ils ne disparaissent.</p>
            </div>
          </div>
          
          <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
            <div class="benefit-item">
              <div class="benefit-icon">
                <i class="bi bi-globe"></i>
              </div>
              <h4>Visibilité</h4>
              <p>Partagez votre culture avec le monde entier et faites-la découvrir à tous.</p>
            </div>
          </div>
          
          <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="400">
            <div class="benefit-item">
              <div class="benefit-icon">
                <i class="bi bi-mortarboard"></i>
              </div>
              <h4>Éducation</h4>
              <p>Contribuez à l'éducation des générations futures sur leur héritage culturel.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>
@endsection
@push('styles')
<style>
    /* ===== MONO-COLOR THEME ===== */
    :root {
        --primary-color: #0ea2bd;
        --primary-dark: #0b8ca3;
        --primary-light: #2cb9d4;
        --text-color: #333333;
        --text-light: #666666;
        --bg-light: #f8f9fa;
        --border-color: #e0e0e0;
        --white: #ffffff;
    }
    
    /* ===== FORM STYLING ===== */
    /* Form Controls */
    .form-control, .form-select {
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 1rem;
        color: var(--text-color);
        background-color: var(--white);
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(14, 162, 189, 0.25);
        outline: none;
    }
    
    textarea.form-control {
        min-height: 180px;
        resize: vertical;
        border-radius: 12px;
    }
    
    .form-label {
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 8px;
        font-size: 0.95rem;
    }
    
    .form-check-input {
        border-radius: 6px;
        border: 2px solid var(--border-color);
    }
    
    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .form-check-label {
        color: var(--text-light);
    }
    
    /* Validation styles */
    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #dc3545;
    }
    
    .form-control.is-invalid:focus,
    .form-select.is-invalid:focus {
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }
    
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }
    
    /* ===== AUTH TABS ===== */
    .auth-tabs .nav-tabs {
        border-bottom: 3px solid var(--border-color);
        border-radius: 15px 15px 0 0;
        overflow: hidden;
    }
    
    .auth-tabs .nav-link {
        color: var(--text-light);
        padding: 18px 30px;
        border: none;
        border-radius: 15px 15px 0 0;
        background: var(--bg-light);
        font-weight: 600;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        border-bottom: 3px solid transparent;
    }
    
    .auth-tabs .nav-link:hover {
        color: var(--primary-color);
        background: rgba(14, 162, 189, 0.1);
    }
    
    .auth-tabs .nav-link.active {
        color: var(--white);
        background: var(--primary-color);
        border-bottom: 3px solid var(--white);
    }
    
    /* ===== AUTH CARDS ===== */
    .auth-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        border: 1px solid var(--border-color);
    }
    
    .auth-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: var(--white);
        padding: 35px;
        text-align: center;
        border-radius: 20px 20px 0 0;
    }
    
    .auth-header h3 {
        color: var(--white);
        margin-bottom: 12px;
        font-size: 1.8rem;
    }
    
    .auth-header p {
        opacity: 0.9;
        margin-bottom: 0;
    }
    
    .auth-card form {
        padding: 35px;
    }
    
    /* ===== BUTTONS ===== */
    .btn {
        border-radius: 12px;
        padding: 14px 28px;
        font-weight: 600;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .btn-primary {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: var(--white);
    }
    
    .btn-primary:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(14, 162, 189, 0.3);
    }
    
    .btn-outline-primary {
        background: transparent;
        border-color: var(--primary-color);
        color: var(--primary-color);
    }
    
    .btn-outline-primary:hover {
        background: var(--primary-color);
        color: var(--white);
        transform: translateY(-2px);
    }
    
    .btn-outline-secondary {
        border-radius: 12px;
        border-color: var(--border-color);
        color: var(--text-light);
    }
    
    .btn-outline-secondary:hover {
        background: var(--bg-light);
        border-color: var(--text-light);
    }
    
    /* ===== CONTRIBUTION CARD ===== */
    .contribution-card {
        background: var(--white);
        border-radius: 25px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.12);
        overflow: hidden;
        border: 1px solid var(--border-color);
    }
    
    .contribution-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: var(--white);
        padding: 45px;
        text-align: center;
        border-radius: 25px 25px 0 0;
    }
    
    .contribution-header h3 {
        color: var(--white);
        margin-bottom: 15px;
        font-size: 2rem;
    }
    
    .contribution-header p {
        opacity: 0.9;
        font-size: 1.1rem;
        max-width: 700px;
        margin: 0 auto;
    }
    
    .contribution-card form {
        padding: 45px;
    }
    
    .section-title {
        border-bottom: 3px solid var(--primary-color);
        padding-bottom: 15px;
        margin-bottom: 30px;
    }
    
    .section-title h4 {
        color: var(--text-color);
        display: flex;
        align-items: center;
        font-size: 1.4rem;
        font-weight: 600;
    }
    
    .contribution-footer {
        background: var(--bg-light);
        padding: 30px;
        border-radius: 20px;
        margin-top: 40px;
        border: 1px solid var(--border-color);
    }
    
    /* ===== CTA CARD ===== */
    .cta-card {
        background: var(--white);
        border-radius: 25px;
        padding: 60px 40px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.1);
        text-align: center;
        border: 2px solid var(--primary-color);
    }
    
    .cta-icon {
        margin-bottom: 25px;
        color: var(--primary-color);
    }
    
    .cta-card h3 {
        color: var(--text-color);
        margin-bottom: 20px;
        font-size: 1.8rem;
    }
    
    .cta-card p {
        color: var(--text-light);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto 30px;
    }
    
    .cta-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    /* ===== BENEFIT ITEMS ===== */
    .benefit-item {
        text-align: center;
        padding: 35px 25px;
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid var(--border-color);
    }
    
    .benefit-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(14, 162, 189, 0.15);
        border-color: var(--primary-color);
    }
    
    .benefit-icon {
        width: 80px;
        height: 80px;
        background: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px auto;
        color: var(--white);
        font-size: 2.2rem;
        transition: all 0.3s ease;
    }
    
    .benefit-item:hover .benefit-icon {
        background: var(--primary-dark);
        transform: scale(1.1);
    }
    
    .benefit-item h4 {
        color: var(--text-color);
        margin-bottom: 15px;
        font-size: 1.4rem;
        font-weight: 600;
    }
    
    .benefit-item p {
        color: var(--text-light);
        line-height: 1.6;
        font-size: 1rem;
    }
    
    /* ===== UTILITY ===== */
    .forgot-password {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
    }
    
    .forgot-password:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }
    
    .alert {
        border-radius: 15px;
        border: 1px solid var(--border-color);
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .alert-info {
        background-color: rgba(14, 162, 189, 0.1);
        border-color: var(--primary-color);
        color: var(--primary-dark);
    }
    
    .alert-success {
        background-color: rgba(25, 135, 84, 0.1);
        border-color: #198754;
        color: #0f5132;
    }
    
    .alert-danger {
        background-color: rgba(220, 53, 69, 0.1);
        border-color: #dc3545;
        color: #842029;
    }
    
    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .auth-tabs .nav-link {
            padding: 15px 20px;
            font-size: 0.95rem;
        }
        
        .auth-card form,
        .contribution-card form {
            padd
            ing: 25px;
        }
        
        .auth-header,
        .contribution-header {
            padding: 30px 20px;
        }
        
        .cta-card {
            padding: 40px 25px;
        }
        
        .cta-buttons {
            flex-direction: column;
        }
        
        .cta-buttons .btn {
            width: 100%;
        }
        
        .btn {
            padding: 12px 24px;
        }
        
        .form-control, .form-select {
            padding: 12px 16px;
        }
        
        .benefit-item {
            padding: 25px 20px;
        }
        
        .benefit-icon {
            width: 70px;
            height: 70px;
            font-size: 1.8rem;
        }
    }
    
    @media (max-width: 576px) {
        .auth-tabs .nav-link {
            padding: 12px 15px;
            font-size: 0.9rem;
        }
        
        .auth-header h3,
        .contribution-header h3 {
            font-size: 1.5rem;
        }
        
        .section-title h4 {
            font-size: 1.2rem;
        }
        
        .benefit-item h4 {
            font-size: 1.2rem;
        }
    }
    
    /* ===== ANIMATIONS ===== */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .auth-card, .contribution-card, .benefit-item, .cta-card {
        animation: fadeIn 0.6s ease-out;
    }
</style>
@endpush



@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // If URL contains ?show=verify, ensure verification step is visible (useful when arriving from header)
  try {
    const params = new URLSearchParams(window.location.search);
    if (params.get('show') === 'verify') {
      const verification = document.getElementById('verification-step');
      if (verification) {
        verification.style.display = 'block';
        verification.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    }
  } catch (e) { /* ignore */ }
    // Éléments DOM
    const verificationStep = document.getElementById('verification-step');
    const quickRegisterStep = document.getElementById('quick-register-step');
    const quickVerifyForm = document.getElementById('quick-verify-form');
    const quickRegisterForm = document.getElementById('quick-register-form');
    const showRegisterBtn = document.getElementById('show-register-btn');
    const backToLoginBtn = document.getElementById('back-to-login-btn');
    
    // Messages d'erreur/succès
    function showAlert(message, type = 'danger') {
        const alertDiv = document.createElement('div');
       
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // Supprimer les anciennes alertes
        document.querySelectorAll('.alert').forEach(alert => alert.remove());
        
        // Insérer la nouvelle alerte
        if (verificationStep.style.display !== 'none') {
            verificationStep.querySelector('form').prepend(alertDiv);
        } else {
            quickRegisterStep.querySelector('form').prepend(alertDiv);
        }
    }
    
    // Vérification rapide
    if (quickVerifyForm) {
        quickVerifyForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('verify-btn');
            const originalText = submitBtn.innerHTML;
            
            // Désactiver le bouton
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Vérification...';
            
            try {
              // Populate hidden full name field expected by backend ('name')
              try {
                const nomEl = document.getElementById('register_nom');
                const prenomEl = document.getElementById('register_prenom');
                const existingName = document.getElementById('register_name');
                let fullName = '';
                if (prenomEl && prenomEl.value) fullName += prenomEl.value.trim();
                if (nomEl && nomEl.value) fullName += (fullName ? ' ' : '') + nomEl.value.trim();
                if (existingName) {
                  existingName.value = fullName;
                } else {
                  const hidden = document.createElement('input');
                  hidden.type = 'hidden'; hidden.name = 'name'; hidden.id = 'register_name'; hidden.value = fullName;
                  this.appendChild(hidden);
                }
              } catch (e) {
                console.warn('Unable to construct full name field', e);
              }

              const formData = new FormData(this);
                
                const response = await fetch('{{ route("contribute.verify") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Redirection vers la page avec formulaire de contribution
                    window.location.href = data.redirect;
                } else {
                    if (data.type === 'not_registered') {
                        // Afficher l'option d'inscription
                        const email = document.getElementById('quick_email').value;
                        document.getElementById('register_email').value = email;
                        showAlert(data.message, 'warning');
                        
                        // Basculer vers le formulaire d'inscription
                        verificationStep.style.display = 'none';
                        quickRegisterStep.style.display = 'block';
                        quickRegisterStep.classList.add('fade-in');
                    } else {
                        showAlert(data.message, 'danger');
                    }
                }
            } catch (error) {
                console.error('Erreur:', error);
                showAlert('Une erreur est survenue. Veuillez réessayer.', 'danger');
            } finally {
                // Réactiver le bouton
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    }
    
    // Afficher le formulaire d'inscription
    if (showRegisterBtn) {
        showRegisterBtn.addEventListener('click', function() {
            verificationStep.style.display = 'none';
            quickRegisterStep.style.display = 'block';
            quickRegisterStep.classList.add('fade-in');
        });
    }
    
    // Retour au formulaire de connexion
    if (backToLoginBtn) {
        backToLoginBtn.addEventListener('click', function() {
            quickRegisterStep.style.display = 'none';
            verificationStep.style.display = 'block';
            verificationStep.classList.add('fade-in');
        });
    }
    
    // Inscription rapide
    if (quickRegisterForm) {
        quickRegisterForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('register-btn');
            const originalText = submitBtn.innerHTML;
            
            // Vérification du mot de passe
            const password = document.getElementById('register_password').value;
            const confirmPassword = document.getElementById('register_password_confirmation').value;
            
            if (password !== confirmPassword) {
                showAlert('Les mots de passe ne correspondent pas.', 'danger');
                return;
            }
            
            // Désactiver le bouton
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Inscription...';
            
            try {
              // Ensure hidden 'name' is populated from prenom + nom before sending
              try {
                const nomEl = document.getElementById('register_nom');
                const prenomEl = document.getElementById('register_prenom');
                let fullName = '';
                if (prenomEl && prenomEl.value) fullName += prenomEl.value.trim();
                if (nomEl && nomEl.value) fullName += (fullName ? ' ' : '') + nomEl.value.trim();
                const existingName = document.getElementById('register_name');
                if (existingName) existingName.value = fullName;
                else {
                  const hidden = document.createElement('input');
                  hidden.type = 'hidden'; hidden.name = 'name'; hidden.id = 'register_name'; hidden.value = fullName;
                  this.appendChild(hidden);
                }
              } catch (e) { console.warn('Failed to build full name', e); }

              const formData = new FormData(this);
                
                const response = await fetch('{{ route("register") }}', {
                  method: 'POST',
                  body: formData,
                  headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                  }
                });

                // Si redirection (inscription réussie qui redirige), suivre
                if (response.redirected) {
                  window.location.href = response.url;
                  return;
                }

                // Essayer de parser la réponse JSON (erreurs de validation ou message)
                let payload = null;
                try {
                  payload = await response.json();
                } catch (e) {
                  // non JSON
                  console.warn('Response not JSON', e);
                }

                if (response.ok) {
                  // Succès mais pas de redirection
                  if (payload && payload.redirect) {
                    window.location.href = payload.redirect;
                  } else {
                    showAlert(payload && payload.message ? payload.message : 'Inscription réussie.', 'success');
                  }
                } else {
                  // Erreurs attendues (422 validation) ou autres
                  if (payload && payload.errors) {
                    // Concaténer tous les messages de validation
                    const msgs = Object.values(payload.errors).flat().join('<br/>');
                    showAlert(msgs, 'danger');
                  } else if (payload && payload.message) {
                    showAlert(payload.message, 'danger');
                  } else {
                    showAlert('Erreur lors de l\'inscription.', 'danger');
                  }
                }
            } catch (error) {
                console.error('Erreur:', error);
                showAlert('Une erreur est survenue. Veuillez réessayer.', 'danger');
            } finally {
                // Réactiver le bouton
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    }
    
    // Validation côté client pour le formulaire de contribution
    const contributionForm = document.getElementById('contribution-form-element');
    if (contributionForm) {
        contributionForm.addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                showAlert('Veuillez remplir tous les champs obligatoires.', 'danger');
                return false;
            }
            
            // Désactiver le bouton de soumission
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Soumission...';
            }
            
            return true;
        });
    }

    // Afficher / masquer le select parent si l'utilisateur choisit 'traduction'
    try {
      const originalRadio = document.getElementById('original');
      const translationRadio = document.getElementById('translation');
      const parentRow = document.getElementById('parent-select-row');
      const parentSelect = document.getElementById('parent_id');

      function updateParentRow() {
        if (translationRadio && translationRadio.checked) {
          if (parentRow) parentRow.style.display = 'block';
          if (parentSelect) parentSelect.setAttribute('required', 'required');
        } else {
          if (parentRow) parentRow.style.display = 'none';
          if (parentSelect) {
            parentSelect.removeAttribute('required');
            parentSelect.value = '';
          }
        }
      }

      if (originalRadio) originalRadio.addEventListener('change', updateParentRow);
      if (translationRadio) translationRadio.addEventListener('change', updateParentRow);

      // Initial state on page load
      updateParentRow();
    } catch (e) { console.warn('parent select toggle error', e); }
});
</script>
@endpush