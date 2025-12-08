@extends('dashboard.layout')

@section('content')
<section id="accueil" class="content-section active">
    <div class="header-container">
        <div class="welcome-card">
            <div class="welcome-icon">
                <img src="{{ asset('admin/accueilmasque.png') }}" alt="Masque africain" /> {{-- Remplacez par votre image de masque --}}
            </div>
            <div class="welcome-info">
                <h2>Welcome, Admin!</h2>
                <p>Tesibate doloritor lia este naiord et tempe es de vidis.</p>
                <p>Veiyenoras temair dotalit fitem lisane.</p>
            </div>
            <div class="small-image">
                <img src="https://via.placeholder.com/80x60" alt="Petite image décorative" /> {{-- Remplacez par votre petite image --}}
            </div>
        </div>
        <div class="cultural-heritage-card">
            <h2>Cultural Heritage Database</h2>
            <div class="heritage-links">
                <a href="#" class="heritage-item">
                    <i class="fas fa-landmark"></i>
                    <span>Historical Sites</span>
                    <p>Bored er eimag tislaels</p>
                </a>
                <a href="#" class="heritage-item">
                    <i class="fas fa-book-open"></i>
                    <span>Oral Traditions</span>
                    <p>Bored er eimag tislaells</p>
                </a>
            </div>
            <div class="benin-flag">
                <img src=" {{ asset('admin/Drapeau.jpeg') }}" alt="Drapeau du Bénin" /> {{-- Remplacez par l'image du drapeau du Bénin --}}
            </div>
        </div>
    </div>

    <div class="stats-and-content-container">
        <div class="left-column">
            <div class="today-metrics-card">
                <h2>Today's Metrics</h2>
                <div class="metrics-grid">
                    <div class="metric-item">
                        <h3>{{ $usersCount ?? '1,500' }}</h3>
                        <p>New Users</p>
                        <div class="chart-placeholder"><img src="https://via.placeholder.com/150x50/f0f0f0/333?text=Chart" alt="Graphique des utilisateurs" /></div>
                    </div>
                    <div class="metric-item">
                        <h3>{{ $viewsCount ?? '75,000' }}</h3>
                        <p>Page Views</p>
                        <div class="chart-placeholder"><img src="https://via.placeholder.com/150x50/f0f0f0/333?text=Chart" alt="Graphique des vues" /></div>
                    </div>
                </div>
            </div>

            <div class="page-views-card">
                <h3>{{ $viewsCount ?? '75,000' }}</h3>
                <p>Page Views</p>
                <div class="chart-placeholder large"><img src="https://via.placeholder.com/350x100/f0f0f0/333?text=Large+Chart" alt="Grand graphique des vues" /></div>
            </div>
        </div>

        <div class="right-column">
            <div class="content-by-region-card">
                <h2>Content by Region</h2>
                <div class="region-chart">
                    <img src="https://via.placeholder.com/150/f0f0f0/333?text=Pie+Chart" alt="Graphique en anneau des régions" /> {{-- Remplacez par un vrai graphique en anneau --}}
                </div>
                <div class="region-labels">
                    <span class="south">South</span>
                    <span class="center">Center</span>
                    <span class="north">North</span>
                </div>
            </div>

            <div class="recent-activity-card">
                <h2>Recent Activities</h2>
                <div class="activity-list">
                    @foreach($recentActivities ?? [] as $activity)
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas {{ $activity['icon'] }}"></i>
                        </div>
                        <div class="activity-details">
                            <p>{{ $activity['description'] }}</p>
                            <span class="activity-time">{{ $activity['time'] ?? 'Just now' }}</span>
                        </div>
                    </div>
                    @endforeach
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="activity-details">
                            <p>User "King_Ghezo" uploaded new artifact</p>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-upload"></i>
                        </div>
                        <div class="activity-details">
                            <p>User "King_Ghezo" uploaded new artifact</p>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="activity-details">
                            <p>New historical site: Fort d'Ouidah added</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection