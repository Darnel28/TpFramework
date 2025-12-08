<aside class="sidebar">
    <div class="sidebar-header">
        <h2></h2>
    </div>
        <div class="sidebar-avatar">
            <img src="{{ asset('admin/DrapeauBenin.jpeg') }}" alt="Masque africain" class="sidebar-mask" />
        </div>
        {{-- CSS moved to public/admin/layout.css for better maintainability --}}
    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="{{ url('/admin/accueil') }}" 
                   class="nav-link {{ request()->is('admin/accueil') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/admin/utilisateurs') }}" 
                   class="nav-link {{ request()->is('dashboard/utilisateurs') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Utilisateurs</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/admin/moderateurs') }}" 
                   class="nav-link {{ request()->is('admin/moderateurs') ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i>
                    <span>Modérateurs</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/admin/regions') }}"
                   class="nav-link {{ request()->is('admin/regions') ? 'active' : '' }}">
                    <i class="fas fa-map-marked-alt"></i>
                    <span>Régions</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/admin/langues') }}" 
                   class="nav-link {{ request()->is('admin/langues') ? 'active' : '' }}">
                    <i class="fas fa-language"></i>
                    <span>Langues</span>
                </a>
            </li>

            <li class="has-submenu">
                <a href="#" class="nav-toggle">
                    <i class="fas fa-file-alt"></i>
                    <span>Contenus</span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="{{ url('/admin/recettes') }}"
                           class="{{ request()->is('admin/recettes') ? 'active' : '' }}">
                           Recettes
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/histoires') }}"
                           class="{{ request()->is('admin/histoires') ? 'active' : '' }}">
                           Histoire/Conte
                        </a>
                    </li>
                   
                </ul>
            </li>

            <li class="has-submenu">
                <a href="#" class="nav-toggle">
                    <i class="fas fa-cog"></i>
                    <span>Paramètres</span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="{{ url('/admin/mot-de-passe') }}"
                           class="{{ request()->is('admin/mot-de-passe') ? 'active' : '' }}">
                           Changer mot de passe
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/deconnexion') }}"
                           class="{{ request()->is('admin/deconnexion') ? 'active' : '' }}">
                           Se déconnecter
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>
