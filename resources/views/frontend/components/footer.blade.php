<footer id="footer" class="footer position-relative dark-background">

  <div class="footer-newsletter">
    <div class="container">
      <div class="row justify-content-center text-center">
        <div class="col-lg-6">
          <h4>Rejoignez Notre Newsletter</h4>
          <p>Abonnez-vous à notre newsletter et recevez les dernières actualités sur notre contenu culturel !</p>
         
        </div>
      </div>
    </div>
  </div>

  <div class="container footer-top">
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6 footer-about">
        <a href="{{ route('home') }}" class="d-flex align-items-center">
          <span class="sitename">Culture Bénin</span>
        </a>
        <div class="footer-contact pt-3">
          <p>Porto-Novo, Bénin</p>
          <p class="mt-3"><strong>Téléphone:</strong> <span>+229 XX XX XX XX</span></p>
          <p><strong>Email:</strong> <span>contact@culturebenin.bj</span></p>
        </div>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Liens Utiles</h4>
        <ul>
          <li><i class="bi bi-chevron-right"></i> <a href="{{ route('home') }}">Accueil</a></li>
          
          <li><i class="bi bi-chevron-right"></i> <a href="{{ route('regions') }}">Régions</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('langues') }}">Langues</a></li>
        </ul>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Nos Services</h4>
        <ul>
          <li><i class="bi bi-chevron-right"></i> <a href="{{ route('contenus') }}">Contenus Culturels</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="{{ route('langues') }}">Langues</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('regions') }}">Régions</a></li>
        </ul>
      </div>

      <div class="col-lg-4 col-md-12">
        <h4>Suivez-nous</h4>
        <p>Restez connecté avec nous sur les réseaux sociaux pour les dernières actualités culturelles</p>
        <div class="social-links d-flex">
          <a href=""><i class="bi bi-twitter-x"></i></a>
          <a href=""><i class="bi bi-facebook"></i></a>
          <a href=""><i class="bi bi-instagram"></i></a>
          <a href=""><i class="bi bi-linkedin"></i></a>
        </div>
      </div>
    </div>
  </div>

  <div class="container copyright text-center mt-4">
    <p>© <span>Copyright</span> <strong class="px-1 sitename">Culture Bénin</strong> <span>Tous droits réservés</span></p>
    <div class="credits">
      Conçu par <a href="#">Votre Équipe</a>
    </div>
  </div>

</footer>