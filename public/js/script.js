// import $ from 'jquery'; // DataTables nécessite jQuery
// window.$ = window.jQuery = $;

// import 'datatables.net-dt';
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initialisation du dashboard...');

    // Éléments DOM
    const navLinks = document.querySelectorAll('.nav-link');
    const contentSections = document.querySelectorAll('.content-section');
    const hasSubmenu = document.querySelectorAll('.has-submenu');

    // Fonction pour afficher une section
    function showSection(sectionId) {
        console.log('Affichage de la section:', sectionId);
        
        // Masquer toutes les sections

        contentSections.forEach(section => {
            section.classList.remove('active');
        });
        
        // Afficher la section demandée
        const targetSection = document.getElementById(sectionId);
        if (targetSection) {
            targetSection.classList.add('active');
            console.log('Section trouvée et affichée');
        } else {
            console.error('Section non trouvée:', sectionId);
        }
    }

    // Fonction pour activer un lien de navigation
    function activateNavLink(link) {
        navLinks.forEach(l => l.classList.remove('active'));
        link.classList.add('active');
    }

    // Gestion des sous-menus
    hasSubmenu.forEach(item => {
        // ciblage du lien toggle du sous-menu (classe dédiée ou l'ancien .nav-link)
        const link = item.querySelector('.nav-toggle') || item.querySelector('.nav-link');

        if (!link) return;

        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href') || '';

            // Ne pas intercepter les liens qui pointent vers des routes réelles
            if (href && !href.startsWith('#')) {
                return; // laisser le navigateur faire la navigation
            }

            e.preventDefault();
            e.stopPropagation();

            console.log('Clic sur sous-menu:', this.getAttribute('data-section'));

            // Fermer les autres sous-menus
            hasSubmenu.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                }
            });

            // Basculer l'état du sous-menu actuel
            item.classList.toggle('active');

            // Activer le lien parent
            activateNavLink(this);
        });
    });

    // Navigation des liens principaux (non sous-menus)
    navLinks.forEach(link => {
        if (!link.parentElement.classList.contains('has-submenu')) {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href') || '';

                // Si le lien pointe vers une route (ex: /admin/...), ne pas intercepter
                if (href && !href.startsWith('#')) {
                    return; // laisser la navigation normale
                }

                e.preventDefault();

                console.log('Clic sur lien principal:', this.getAttribute('data-section'));

                // Fermer tous les sous-menus
                hasSubmenu.forEach(item => {
                    item.classList.remove('active');
                });

                // Activer le lien
                activateNavLink(this);

                // Afficher la section
                const sectionId = this.getAttribute('data-section');
                showSection(sectionId);
            });
        }
    });

    // Navigation des sous-menus items
    const submenuLinks = document.querySelectorAll('.submenu a');

    submenuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href') || '';

            // Si le lien pointe vers une route réelle, laisser la navigation normale
            if (href && !href.startsWith('#')) {
                return; // navigation normale vers la page serveur
            }

            e.preventDefault();
            e.stopPropagation();

            console.log('Clic sur sous-menu item:', this.getAttribute('data-subsection'));

            // Activer le lien parent
            const parentNav = this.closest('.has-submenu').querySelector('.nav-link');
            activateNavLink(parentNav);

            // Afficher la section
            const subsectionId = this.getAttribute('data-subsection');
            showSection(subsectionId);

            // Fermer le sous-menu après sélection
            const parentSubmenu = this.closest('.has-submenu');
            parentSubmenu.classList.remove('active');
        });
    });

    // Fermer les sous-menus en cliquant ailleurs
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.has-submenu')) {
            hasSubmenu.forEach(item => {
                item.classList.remove('active');
            });
        }
    });

    // Afficher la section active au chargement
    const currentSection = window.location.hash.replace('#', '') || 'accueil';
    showSection(currentSection);
    
    // Activer le lien correspondant
    const activeLink = document.querySelector(`[data-section="${currentSection}"]`);
    if (activeLink) {
        activateNavLink(activeLink);
    }

    console.log('Dashboard initialisé avec succès');
});