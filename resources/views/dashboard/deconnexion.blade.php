@extends('dashboard.layout')

@section('content')
<section id="deconnexion" class="content-section">
    <style>
        .logout-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }
        .logout-card {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }
        .logout-icon {
            font-size: 50px;
            color: #f72585;
            margin-bottom: 20px;
        }
        h2 {
            margin: 0 0 10px 0;
            color: #333;
        }
        p {
            margin: 0 0 30px 0;
            color: #555;
        }
        .logout-actions {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        .logout-actions button, .logout-actions form button {
            flex: 1;
            padding: 10px 0;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-secondary {
            background: #ccc;
            color: #333;
        }
        .btn-secondary:hover {
            background: #bbb;
        }
        .btn-primary {
            background: #4361ee;
            color: #fff;
        }
        .btn-primary:hover {
            background: #3f37c9;
        }
    </style>

    <div class="logout-container">
        <div class="logout-card">
            <div class="logout-icon">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <h2>Déconnexion</h2>
            <p>Voulez-vous vraiment vous déconnecter ?</p>
            <div class="logout-actions">
                <button class="btn btn-secondary" onclick="window.history.back()">Annuler</button>
                   @if (Auth::check())
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-button">Se deconnecter</button>
            </form>
        @endif
            </div>
        </div>
    </div>
</section>
@endsection
