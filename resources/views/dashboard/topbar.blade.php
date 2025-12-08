<header class="top-bar">
    <div class="user-menu-wrapper">
        <div class="user-info" id="adminMenuToggle">
            <div class="user-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <span class="user-name">{{ Auth::user()->name ?? 'Admin' }}</span>
            <i class="fas fa-chevron-down menu-chevron"></i>
        </div>
        
        <!-- Dropdown Menu -->
        <div class="user-dropdown-menu" id="adminDropdown">
            <div class="dropdown-header">
                <i class="fas fa-user-circle"></i>
                <span>{{ Auth::user()->name ?? 'Admin' }}</span>
            </div>
            <div class="dropdown-divider"></div>
            <a href="{{ url('/admin/mot-de-passe') }}" class="dropdown-item">
                <i class="fas fa-lock"></i>
                <span>Changer mot de passe</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{ url('/admin/deconnexion') }}" class="dropdown-item danger">
                <i class="fas fa-sign-out-alt"></i>
                <span>Se déconnecter</span>
            </a>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('adminMenuToggle');
    const dropdown = document.getElementById('adminDropdown');
    
    if (menuToggle && dropdown) {
        menuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const isActive = dropdown.classList.toggle('active');
            menuToggle.classList.toggle('active', isActive);
        });
        
        document.addEventListener('click', function(e) {
            if (!menuToggle.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('active');
                menuToggle.classList.remove('active');
            }
        });
    }
});
</script>