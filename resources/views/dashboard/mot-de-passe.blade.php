@extends('dashboard.layout')

@section('content')
<section id="mot-de-passe" class="content-section">
    <style>
        #mot-de-passe {
            padding: 30px;
            display: flex;
            justify-content: center;
        }

        .form-container {
            background: #fff;
            padding: 30px 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }

        .section-header h1 {
            text-align: center;
            color: #4361ee;
            margin-bottom: 25px;
            font-size: 24px;
        }

        .settings-form .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        .settings-form .form-group label {
            margin-bottom: 6px;
            font-weight: 600;
            color: #333;
        }

        .settings-form .form-group input {
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .settings-form .form-group input:focus {
            border-color: #4361ee;
            outline: none;
        }

        .settings-form .btn-primary {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: #4361ee;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .settings-form .btn-primary:hover {
            background-color: #3f37c9;
        }

        @media (max-width: 500px) {
            .form-container {
                padding: 20px;
            }
            .section-header h1 {
                font-size: 20px;
            }
        }
    </style>

    <div class="form-container">
        <div class="section-header">
            <h1>Changer le mot de passe</h1>
        </div>
        <form class="settings-form">
            <div class="form-group">
                <label for="current-password">Mot de passe actuel</label>
                <input type="password" id="current-password" required>
            </div>
            <div class="form-group">
                <label for="new-password">Nouveau mot de passe</label>
                <input type="password" id="new-password" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirmer le nouveau mot de passe</label>
                <input type="password" id="confirm-password" required>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour le mot de passe</button>
        </form>
    </div>
</section>
@endsection
