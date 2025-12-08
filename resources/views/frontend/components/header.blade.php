<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

    <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto me-xl-0">
      <h1 class="sitename d-flex align-items-center">
        <span class="logo-icon" aria-hidden="true">
          <!-- Leaf SVG icon -->
          <svg class="logo-svg" focusable="false" aria-hidden="true" viewBox="0 0 100 140" xmlns="http://www.w3.org/2000/svg" role="img">
            <path d="M50 2 C72 20 92 55 50 132 C8 55 28 20 50 2 Z" fill="currentColor"/>
            <path d="M50 24 L50 116" stroke="#fff" stroke-width="2" stroke-linecap="round" fill="none" opacity="0.9"/>
            <circle cx="50" cy="42" r="5" fill="#fff" opacity="0.9"/>
            <rect x="37" y="56" width="5" height="8" rx="1" fill="#fff" opacity="0.9" transform="rotate(-20 37 56)"/>
            <rect x="59" y="56" width="5" height="8" rx="1" fill="#fff" opacity="0.9" transform="rotate(20 59 56)"/>
            <polygon points="50,76 42,88 58,88" fill="#fff" opacity="0.9"/>
            <rect x="45" y="98" width="10" height="5" rx="1" fill="#fff" opacity="0.9"/>
          </svg>
        </span>
        <span class="logo-text">Culture Bénin <span class="logo-subtext">HÉRITAGE & TRADITIONS</span></span>
      </h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <!-- <li><a href="{{ route('decouvrir') }}" class="{{ request()->routeIs('decouvrir') ? 'active' : '' }}"> Découvrir</a></li> -->
        <li><a href="{{ route('contenus') }}" class="{{ request()->routeIs('contenus') ? 'active' : '' }}">Découvertes</a></li>
        <li><a href="{{ route('langues') }}" class="{{ request()->routeIs('langues') ? 'active' : '' }}">Langues & Dialectes</a></li>
        <li><a href="{{ route('regions') }}" class="{{ request()->routeIs('regions') ? 'active' : '' }}">Horizons Béninois</a></li>     
       
        
        <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">À propos</a></li>
        <!-- <li><a href="{{ route('blog') }}" class="{{ request()->routeIs('blog') ? 'active' : '' }}">Blog</a></li> -->
        <!-- <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li> -->
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    @auth
      @php $role = auth()->user()->id_role ?? null; @endphp
      @if($role == 2)
        <a class="btn-getstarted" href="{{ url('/admin/accueil') }}">Tableau Admin</a>
      @elseif($role == 3)
        <a class="btn-getstarted" href="{{ url('/moderateur/accueil') }}">Tableau Modérateur</a>
      @else
        <a id="contrib-btn" class="btn-getstarted" href="{{ route('contribute') }}">Contribuer</a>
      @endif

      <form method="POST" action="{{ route('logout') }}" class="logout-form d-inline">
        @csrf
        <button type="submit" class="btn-getstarted logout-button">Se deconnecter</button>
      </form>
    @else
      <a class="btn-getstarted" href="{{ route('login') }}">Se connecter</a>
    @endauth

  </div>
</header>