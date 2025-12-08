<aside class="sidebar">
    <div class="sidebar-header">
        <h2></h2>
    </div>
    <div class="sidebar-avatar">
        <img src="{{ asset('admin/DrapeauBenin.jpeg') }}" alt="Masque africain" class="sidebar-mask" />
    </div>

    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="{{ url('/moderateur/accueil') }}" 
                   class="nav-link {{ request()->is('moderateur/accueil') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Accueil</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/moderateur/contenus') }}" 
                   class="nav-link {{ request()->is('moderateur/contenus') ? 'active' : '' }}">
                    <i class="fas fa-inbox"></i>
                    <span>Contenu en attente</span>
                </a>
            </li>

            <li>
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="fas fa-undo"></i>
                    <span>Retour au site</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
