@extends('frontend.app')
@section('content')
<main class="main">

    <!-- Page Title -->
     <div class="page-title dark-background" data-aos="fade" style="background-color: #0ea2bd;">
      <div class="container position-relative">
        <h1>À propos</h1>
        <p>Culture Bénin est une plateforme dédiée à la préservation, la valorisation et la transmission du patrimoine culturel béninois à travers la contribution citoyenne et le travail collaboratif avec des spécialistes locaux.</p>
        <nav class="breadcrumbs">
          <ol>
             <li><a href="{{ route('home') }}">Accueil</a></li>
            <li class="current">À  Propos</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Travel About Section -->
    <section id="travel-about" class="travel-about section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
          <div class="col-lg-8 mx-auto text-center mb-5">
            <div class="intro-content" data-aos="fade-up" data-aos-delay="200">
              <h2>Préserver et partager<br>le patrimoine culturel</h2>
              <p class="lead">Ce projet rassemble témoignages, récits, savoir-faire et pratiques vivantes du Bénin pour en assurer la mémoire et faciliter leur accès aux communautés et aux chercheurs.</p>
            </div>
          </div>
        </div>

        <div class="row align-items-center mb-5">
          <div class="col-lg-5" data-aos="zoom-in" data-aos-delay="300">
            <div class="hero-image">
              <img src="assets/img/travel/logo.png" class="img-fluid" alt="Travel Adventure">
              <div class="floating-stats">
                <div class="stat-item">
                  <span class="number">50+</span>
                  <span class="label">Regions</span>
                </div>
                <div class="stat-item">
                  <span class="number">15K</span>
                  <span class="label">Lecteurs</span>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6 offset-lg-1" data-aos="slide-left" data-aos-delay="400">
            <div class="story-content">
              <div class="story-badge">
                <i class="bi bi-compass"></i>
                <span>Notre Histoire</span>
              </div>
              <h3>Une initiative portée par le terrain</h3>
              <p>Culture Bénin est née d'un constat : de nombreux savoirs et récits restent fragiles faute de documentation et de circulation. Nous travaillons avec des contributeurs, des chercheurs et des associations locales pour recueillir, vérifier et partager ces ressources.</p>
              <p>Nos actions visent à respecter les communautés détentrices des connaissances, à valoriser leurs acteurs locaux et à garantir une diffusion éthique des contenus.</p>

              <div class="mission-box">
                <div class="mission-icon">
                  <i class="bi bi-globe-americas"></i>
                </div>
                <div class="mission-text">
                  <h4>Notre vision</h4>
                  <p>Faire du patrimoine culturel béninois une ressource vivante et accessible, préservée pour les générations futures.</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="features-grid" data-aos="fade-up" data-aos-delay="200">
              <div class="section-header text-center mb-5">
                <h3>Pourquoi Culture Bénin</h3>
                <p>Nos principes pour une valorisation responsable du patrimoine</p>
              </div>

              <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                  <div class="feature-card">
                    <div class="feature-front">
                      <div class="feature-icon">
                        <i class="bi bi-people"></i>
                      </div>
                      <h4>Partenariats locaux</h4>
                      <p>Travail direct avec des acteurs et associations locales.</p>
                    </div>
                    <div class="feature-back">
                      <p></p>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                  <div class="feature-card">
                    <div class="feature-front">
                      <div class="feature-icon">
                        <i class="bi bi-heart-pulse"></i>
                      </div>
                      <h4>Respect et sécurité</h4>
                      <p>Procédures respectueuses des personnes et protection des sources.</p>
                    </div>
                    <div class="feature-back">
                      <p></p>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                  <div class="feature-card">
                    <div class="feature-front">
                      <div class="feature-icon">
                        <i class="bi bi-recycle"></i>
                      </div>
                      <h4>Durabilité</h4>
                      <p>Approche attentive aux impacts sociaux et environnementaux.</p>
                    </div>
                    <div class="feature-back">
                      <p></p>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                  <div class="feature-card">
                    <div class="feature-front">
                      <div class="feature-icon">
                        <i class="bi bi-sliders"></i>
                      </div>
                      <h4>Contenus vérifiés</h4>
                      <p>Documentation sourcée et validée par des spécialistes.</p>
                    </div>
                    <div class="feature-back">
                      <p></p>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                  <div class="feature-card">
                    <div class="feature-front">
                      <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                      </div>
                      <h4>Ouverture</h4>
                      <p>Plateforme ouverte aux contributions citoyennes avec modération.</p>
                    </div>
                    <div class="feature-back">
                      <p></p>
                    </div>
                  </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                  <div class="feature-card">
                    <div class="feature-front">
                      <div class="feature-icon">
                        <i class="bi bi-star"></i>
                      </div>
                      <h4>Transmission</h4>
                      <p>Conserver et transmettre des savoirs pour l'éducation et la recherche.</p>
                    </div>
                    <div class="feature-back">
                      <p></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-5">
          <div class="col-lg-12">
            <div class="journey-timeline" data-aos="fade-up" data-aos-delay="200">
              <div class="timeline-header text-center mb-5">
                <h3>Étapes et réalisations</h3>
                <p>Quelques jalons qui structurent le projet</p>
              </div>

              <div class="timeline-container">
                <div class="timeline-track"></div>

                <div class="timeline-milestone" data-aos="slide-right" data-aos-delay="300">
                  <div class="milestone-marker">
                    <span class="year">2020</span>
                  </div>
                  <div class="milestone-content">
                    <h4>Les origines</h4>
                    <p>Le projet a commencé comme un recueil local de témoignages et s'est progressivement structuré en une plateforme collaborative.</p>
                  </div>
                </div>

                <div class="timeline-milestone" data-aos="slide-left" data-aos-delay="400">
                  <div class="milestone-marker">
                    <span class="year">2022</span>
                  </div>
                  <div class="milestone-content">
                    <h4>Déploiement</h4>
                    <p>Nous avons élargi notre réseau de contributeurs et établi des collaborations avec des institutions culturelles.</p>
                  </div>
                </div>

                <div class="timeline-milestone" data-aos="slide-right" data-aos-delay="500">
                  <div class="milestone-marker">
                    <span class="year">2024</span>
                  </div>
                  <div class="milestone-content">
                    <h4>Impact local</h4>
                    <p>Des actions concrètes de valorisation qui visent à soutenir les détenteurs du patrimoine et les initiatives communautaires.</p>
                  </div>
                </div>

                <div class="timeline-milestone" data-aos="slide-left" data-aos-delay="600">
                  <div class="milestone-marker">
                    <span class="year">2025</span>
                  </div>
                  <div class="milestone-content">
                    <h4>Perspectives</h4>
                    <p>Renforcer l'archivage numérique, développer des programmes éducatifs et encourager la recherche autour des contenus collectés.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <main class="main">
           <section id="testimonials-home" class="testimonials-home section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Foires Aux Questions</h2>

  
    <section id="faq" class="faq section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-start gy-4">
          <div class="col-lg-5" data-aos="fade-up" data-aos-delay="200">
            <div class="faq-sidebar">
              <div class="faq-image">
                <img src="assets/img/illustration/illustration-5.webp" alt="FAQ Image" class="img-fluid" loading="lazy">
              </div>
              <div class="contact-box">
                <h3><i class="bi bi-headset"></i> Besoin d'assistance?</h3>
                <p>Vous avez des questions sur la plateforme, la contribution de contenus ou l'accès aux ressources? Consultez nos réponses aux questions fréquentes ci-dessous.</p>
                <a href="{{ route('contact') }}" class="btn-contact">Contactez-nous</a>
              </div>
            </div>
          </div>

          <div class="col-lg-7">
            <div class="faq-tabs">
              <ul class="nav nav-pills mb-4" id="faqTabs-faq" role="tablist" data-aos="fade-up" data-aos-delay="100">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="general-tab-faq" data-bs-toggle="pill" data-bs-target="#general-faq-faq" type="button" role="tab" aria-controls="general-faq-faq" aria-selected="true">À propos du projet</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="account-tab-faq" data-bs-toggle="pill" data-bs-target="#account-faq-faq" type="button" role="tab" aria-controls="account-faq-faq" aria-selected="false">Contribuer</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="payment-tab-faq" data-bs-toggle="pill" data-bs-target="#payment-faq-faq" type="button" role="tab" aria-controls="payment-faq-faq" aria-selected="false">Accès et Utilisation</button>
                </li>
              </ul>

              <div class="tab-content" id="faqTabsContent-faq">
                <div class="tab-pane fade show active" id="general-faq-faq" role="tabpanel" aria-labelledby="general-tab-faq">
                  <div class="accordion" id="generalAccordion-faq">
                    <div class="faq-item" data-aos="fade-up" data-aos-delay="150">
                      <h3>Qu'est-ce que Culture Bénin?</h3>
                      <div class="faq-content">
                        <p>Culture Bénin est une plateforme numérique collaborative dédiée à la préservation, la valorisation et la transmission du patrimoine culturel béninois. Nous travaillons avec des contributeurs locaux, des chercheurs et des associations pour documenter et partager les savoirs, les récits, les pratiques et les traditions du Bénin.</p>
                      </div>
                      <i class="bi bi-chevron-down faq-toggle"></i>
                    </div><!-- End FAQ Item-->

                    <div class="faq-item" data-aos="fade-up" data-aos-delay="200">
                      <h3>Qui peut utiliser la plateforme?</h3>
                      <div class="faq-content">
                        <p>Culture Bénin est ouverte à tous : citoyens, chercheurs, étudiants, journalistes et passionnés par le patrimoine culturel béninois. Vous pouvez consulter librement les contenus, créer un compte pour contribuer vos propres récits et pratiques, ou simplement explorer les ressources documentées.</p>
                      </div>
                      <i class="bi bi-chevron-down faq-toggle"></i>
                    </div><!-- End FAQ Item-->

                    <div class="faq-item" data-aos="fade-up" data-aos-delay="250">
                      <h3>Quels types de contenus sont acceptés?</h3>
                      <div class="faq-content">
                        <p>Nous acceptons une variété de contenus : récits oraux, traditions, pratiques artisanales, recettes culinaires, danses, musiques, proverbes, articles sur les personnalités culturelles, photos et vidéos documentaires. Tous les contenus sont vérifiés par notre équipe pour assurer leur authenticité et leur qualité avant publication.</p>
                      </div>
                      <i class="bi bi-chevron-down faq-toggle"></i>
                    </div><!-- End FAQ Item-->

                    <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                      <h3>Qu'est-ce qui rend Culture Bénin unique?</h3>
                      <div class="faq-content">
                        <p>Culture Bénin privilégie le partenariat avec les acteurs locaux et les détenteurs du savoir. Nous garantissons une diffusion éthique des contenus, nous respectons les droits des contributeurs et nous travaillons à créer une mémoire collective vivante et accessible pour les générations futures.</p>
                      </div>
                      <i class="bi bi-chevron-down faq-toggle"></i>
                    </div><!-- End FAQ Item-->

                    <div class="faq-item" data-aos="fade-up" data-aos-delay="350">
                      <h3>La plateforme est-elle gratuite?</h3>
                      <div class="faq-content">
                        <p>Oui, l'accès à Culture Bénin est entièrement gratuit. Vous pouvez explorer tous nos contenus sans frais. La contribution est également gratuite et accessible à tous ceux qui souhaitent partager leur savoir-faire et leurs récits avec la communauté.</p>
                      </div>
                      <i class="bi bi-chevron-down faq-toggle"></i>
                    </div><!-- End FAQ Item-->
                  </div>
                </div>

                <div class="tab-pane fade" id="account-faq-faq" role="tabpanel" aria-labelledby="account-tab-faq">
                  <div class="accordion" id="accountAccordion-faq">
                    <div class="faq-item" data-aos="fade-up" data-aos-delay="150">
                      <h3>Comment créer un compte contributeur?</h3>
                      <div class="faq-content">
                        <p>Pour créer un compte, cliquez sur "S'inscrire" en haut de la page. Remplissez le formulaire avec vos informations personnelles, créez un identifiant et un mot de passe sécurisé, puis validez votre email. Vous aurez ensuite accès à votre espace contributeur.</p>
                      </div>
                      <i class="bi bi-chevron-down faq-toggle"></i>
                    </div><!-- End FAQ Item-->

                    <div class="faq-item" data-aos="fade-up" data-aos-delay="200">
                      <h3>Comment soumettre une contribution?</h3>
                      <div class="faq-content">
                        <p>Une fois connecté, accédez à votre tableau de bord et cliquez sur "Ajouter un nouveau contenu". Remplissez le formulaire avec les détails de votre contribution (titre, description, type de contenu, images/vidéos si disponible), puis soumettez. Notre équipe examinera votre contribution et vous notifiera de sa publication.</p>
                      </div>
                      <i class="bi bi-chevron-down faq-toggle"></i>
                    </div><!-- End FAQ Item-->

                    <div class="faq-item" data-aos="fade-up" data-aos-delay="250">
                      <h3>Puis-je modifier ou supprimer ma contribution?</h3>
                      <div class="faq-content">
                        <p>Oui, vous pouvez modifier votre contribution tant qu'elle n'a pas été publiée. Une fois publiée, vous pouvez toujours demander une modification ou une suppression en nous contactant. Nous nous engageons à respecter vos souhaits concernant vos contenus.</p>
                      </div>
                      <i class="bi bi-chevron-down faq-toggle"></i>
                    </div><!-- End FAQ Item-->

                    <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                      <h3>Ma contribution sera-t-elle créditée à mon nom?</h3>
                      <div class="faq-content">
                        <p>Absolument! Toutes les contributions publiées mentionnent le nom de l'auteur/contributeur. Vous serez reconnu pour votre apport à la préservation du patrimoine culturel béninois. Vous pouvez également créer un profil public pour être suivi par d'autres utilisateurs.</p>
                      </div>
                      <i class="bi bi-chevron-down faq-toggle"></i>
                    </div><!-- End FAQ Item-->
                  </div>
                </div>

                <div class="tab-pane fade" id="payment-faq-faq" role="tabpanel" aria-labelledby="payment-tab-faq">
                  <div class="accordion" id="paymentAccordion-faq">
                    <div class="faq-item" data-aos="fade-up" data-aos-delay="150">
                      <h3>Comment rechercher un contenu spécifique?</h3>
                      <div class="faq-content">
                        <p>Utilisez la barre de recherche en haut de la page ou naviguez par catégories (traditions, recettes, personnalités, etc.). Vous pouvez également filtrer par région du Bénin pour explorer le patrimoine d'une zone spécifique.</p>
                      </div>
                      <i class="bi bi-chevron-down faq-toggle"></i>
                    </div><!-- End FAQ Item-->

                    <div class="faq-item" data-aos="fade-up" data-aos-delay="200">
                      <h3>Puis-je partager les contenus sur les réseaux sociaux?</h3>
                      <div class="faq-content">
                        <p>Oui, vous pouvez partager les contenus de Culture Bénin sur les réseaux sociaux. Nous vous demandons de créditer l'auteur original et Culture Bénin. Chaque contenu peut être partagé via les boutons de partage disponibles sur la page.</p>
                      </div>
                      <i class="bi bi-chevron-down faq-toggle"></i>
                    </div><!-- End FAQ Item-->

                    <div class="faq-item" data-aos="fade-up" data-aos-delay="250">
                      <h3>Comment citer un contenu de Culture Bénin?</h3>
                      <div class="faq-content">
                        <p>Chaque contenu dispose d'un format de citation fourni. Pour citer, incluez le titre du contenu, le nom de l'auteur/contributeur, la date de publication et le lien vers Culture Bénin. Les chercheurs et étudiants peuvent utiliser nos contenus comme sources académiques.</p>
                      </div>
                      <i class="bi bi-chevron-down faq-toggle"></i>
                    </div><!-- End FAQ Item-->

                    <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                      <h3>Quels sont les droits d'utilisation des contenus?</h3>
                      <div class="faq-content">
                        <p>Les contenus de Culture Bénin sont protégés. Vous pouvez les consulter, les partager et les utiliser à titre éducatif ou informatif avec attribution appropriée. Une utilisation commerciale ou la modification sans permission n'est pas autorisée. Consultez nos conditions d'utilisation pour plus de détails.</p>
                      </div>
                      <i class="bi bi-chevron-down faq-toggle"></i>
                    </div><!-- End FAQ Item-->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Faq Section -->
</div>

 

        <div class="row mt-5">
          <div class="col-lg-12">
            <div class="cta-banner" data-aos="zoom-in" data-aos-delay="300">
              <div class="cta-overlay">
                <div class="cta-content">
                  <h3>Contribuez et participez</h3>
                  <p>Vous pouvez contribuer des récits, des pratiques, des recettes ou des images. Chaque apport aide à enrichir la mémoire collective.</p>
                  <div class="cta-buttons">
                    <a href="{{ route('contribute') }}" class="btn btn-primary me-3">Contribuer</a>
                    <a href="{{ route('contact') }}" class="btn btn-outline">Nous contacter</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Travel About Section -->

  </main>
  
@endsection