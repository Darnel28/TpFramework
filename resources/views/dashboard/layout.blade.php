<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <!-- Font Awesome icons (CDN) - load first so our CSS does not override font settings -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('admin/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/layout.css') }}">
  
</head>
<body>
    <div class="dashboard-container">
        <!-- Barre latérale -->
        @include('dashboard.sidebar')
        
        <!-- Contenu principal -->
        <main class="main-content">
            @include('dashboard.topbar')
            
            <div class="content-area">
                <!-- Sections de contenu -->
                @yield('content')
            </div>
        </main>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>