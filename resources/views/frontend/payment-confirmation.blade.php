@extends('frontend.app')

@section('title', 'Confirmation de Paiement - Culture Bénin')

@section('content')
<main class="main">
    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-color: #0ea2bd;">
        <div class="container position-relative">
            <h1>Confirmation de Paiement</h1>
            <p>Finalisez votre accès au contenu premium</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li class="current">Paiement</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Payment Confirmation Section -->
    <section id="payment-confirmation" class="payment-confirmation section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="payment-card">
                        <div class="payment-header">
                            <i class="bi bi-lock-fill" style="font-size: 3rem; color: #f0ad4e; margin-bottom: 15px;"></i>
                            <h2>Accès au Contenu Premium</h2>
                        </div>

                        <div class="payment-details">
                            <div class="detail-item">
                                <span class="label">Montant</span>
                                <span class="value"><strong>100 XOF</strong></span>
                            </div>
                            <div class="detail-item">
                                <span class="label">Devise</span>
                                <span class="value">Franc CFA (XOF)</span>
                            </div>
                            <div class="detail-item">
                                <span class="label">Plateforme de paiement</span>
                                <span class="value">FedaPay</span>
                            </div>
                        </div>

                        <div class="payment-info">
                            <p style="text-align: center; color: #666; margin-bottom: 20px;">
                                <i class="bi bi-info-circle" style="color: #0ea2bd; margin-right: 8px;"></i>
                                Vous allez être redirigé vers FedaPay pour finaliser le paiement de manière sécurisée.
                            </p>
                        </div>

                        <div class="payment-benefits">
                            <h4 style="margin-bottom: 15px;">Ce que vous obtenez :</h4>
                            <ul style="list-style: none; padding: 0;">
                                <li style="padding: 8px 0;">
                                    <i class="bi bi-check-circle-fill" style="color: #28a745; margin-right: 10px;"></i>
                                    Accès au contenu complet
                                </li>
                                <li style="padding: 8px 0;">
                                    <i class="bi bi-check-circle-fill" style="color: #28a745; margin-right: 10px;"></i>
                                    Accès illimité et permanent
                                </li>
                                <li style="padding: 8px 0;">
                                    <i class="bi bi-check-circle-fill" style="color: #28a745; margin-right: 10px;"></i>
                                    Paiement sécurisé
                                </li>
                            </ul>
                        </div>

                        <button type="button" id="proceedPaymentBtn" class="btn btn-primary" 
                                data-content-id="{{ $contentId ?? 0 }}"
                                style="width: 100%; background: #f0ad4e; border: none; padding: 12px; border-radius: 6px; font-weight: 600; font-size: 1.1rem; cursor: pointer;">
                            <i class="bi bi-lock-fill" style="margin-right: 8px;"></i>
                            Procéder au Paiement
                        </button>

                        <a href="{{ route('content.details', $contentId ?? 0) }}" class="btn btn-outline" 
                           style="width: 100%; margin-top: 10px; display: block; text-align: center; padding: 12px; border: 2px solid #ddd; border-radius: 6px; color: #333; text-decoration: none; transition: all 0.3s;">
                            Annuler
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /Payment Confirmation Section -->
</main>

<style>
    .payment-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-bottom: 30px;
    }

    .payment-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .payment-header h2 {
        margin: 0;
        color: #333;
        font-size: 1.5rem;
    }

    .payment-details {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-item .label {
        color: #666;
        font-weight: 500;
    }

    .detail-item .value {
        color: #333;
        font-weight: 600;
    }

    .payment-benefits {
        background: #f0f8ff;
        padding: 15px;
        border-left: 4px solid #0ea2bd;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .payment-benefits h4 {
        margin: 0 0 10px 0;
        color: #0ea2bd;
    }

    .payment-benefits ul {
        margin: 0;
    }

    .btn-outline {
        color: #333;
        transition: all 0.3s;
    }

    .btn-outline:hover {
        background-color: #f8f9fa;
        border-color: #0ea2bd;
        color: #0ea2bd;
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const proceedBtn = document.getElementById('proceedPaymentBtn');
        
        if (proceedBtn) {
            proceedBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                const contentId = this.getAttribute('data-content-id');
                const btn = this;
                
                // Désactiver le bouton pendant le traitement
                btn.disabled = true;
                btn.innerHTML = '<i class="bi bi-hourglass-split" style="margin-right:6px;"></i>Traitement...';
                
                // Appeler l'API pour créer la transaction FedaPay
                fetch('{{ route("fedapay.pay") }}?content_id=' + contentId)
                    .then(response => response.json())
                    .then(data => {
                        if (data.payment_url) {
                            // Rediriger vers FedaPay
                            window.location.href = data.payment_url;
                        } else if (data.error) {
                            alert('Erreur: ' + (data.message || 'Une erreur est survenue'));
                            btn.disabled = false;
                            btn.innerHTML = '<i class="bi bi-lock-fill" style="margin-right:8px;"></i>Procéder au Paiement';
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Erreur de connexion. Veuillez réessayer.');
                        btn.disabled = false;
                        btn.innerHTML = '<i class="bi bi-lock-fill" style="margin-right:8px;"></i>Procéder au Paiement';
                    });
            });
        }
    });
</script>
@endpush
