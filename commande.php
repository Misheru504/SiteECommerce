<?php
$currentPage = 'commande';
$pageTitle = 'Commande';

/**
 * Page de commande — maquette statique.
 * Le traitement PHP (facture, validation) sera ajouté plus tard.
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('inc/header.inc.php'); ?>
</head>
<body>
    <?php include('inc/navbar.inc.php'); ?>

    <!-- Breadcrumb -->
    <div class="page-header">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "?controller=Panier&action=showCartPage" ?>">Panier</a></li>
                    <li class="breadcrumb-item active">Commande</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="py-5">
        <div class="container">
            <h2 class="section-title mb-4">Finaliser ma commande</h2>

            <div class="row g-4">
                <!-- Formulaire de livraison -->
                <div class="col-lg-7">
                    <div class="auth-card">
                        <h4 class="fw-bold mb-3"><i class="bi bi-geo-alt me-2 text-orange"></i>Adresse de livraison</h4>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Prénom</label>
                                <input type="text" class="form-control" placeholder="Jean">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nom</label>
                                <input type="text" class="form-control" placeholder="Dupont">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Adresse</label>
                                <input type="text" class="form-control" placeholder="42 Rue des Briques">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Code postal</label>
                                <input type="text" class="form-control" placeholder="75001">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Ville</label>
                                <input type="text" class="form-control" placeholder="Paris">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" class="form-control" placeholder="06 12 34 56 78">
                            </div>
                        </div>

                        <hr class="my-4">

                        <h4 class="fw-bold mb-3"><i class="bi bi-credit-card me-2 text-orange"></i>Paiement</h4>

                        <div class="mb-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment" id="payCard" checked>
                                <label class="form-check-label fw-600" for="payCard">
                                    <i class="bi bi-credit-card-2-front me-1"></i>Carte bancaire
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment" id="payPaypal">
                                <label class="form-check-label fw-600" for="payPaypal">
                                    <i class="bi bi-paypal me-1"></i>PayPal
                                </label>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Numéro de carte</label>
                                <input type="text" class="form-control" placeholder="1234 5678 9012 3456">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date d'expiration</label>
                                <input type="text" class="form-control" placeholder="MM/AA">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">CVV</label>
                                <input type="text" class="form-control" placeholder="123">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Résumé commande -->
                <div class="col-lg-5">
                    <div class="cart-summary">
                        <h5>Récapitulatif</h5>

                        <!-- Articles (en dur, comme le panier) -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small">Millennium Falcon x1</span>
                                <span class="small fw-bold">169,99 &euro;</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small">Iron Man MK50 x2</span>
                                <span class="small fw-bold">29,98 &euro;</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="small">Station Spatiale Internationale x1</span>
                                <span class="small fw-bold">69,99 &euro;</span>
                            </div>
                        </div>

                        <hr>

                        <div class="cart-summary-row">
                            <span>Sous-total</span>
                            <span>269,96 &euro;</span>
                        </div>
                        <div class="cart-summary-row">
                            <span>Livraison</span>
                            <span class="text-success fw-bold">Gratuite</span>
                        </div>

                        <hr>

                        <div class="cart-summary-row cart-summary-total">
                            <span>Total</span>
                            <span>269,96 &euro;</span>
                        </div>

                        <button class="btn btn-checkout mt-3">
                            <i class="bi bi-check-circle me-2"></i>Confirmer la commande
                        </button>

                        <p class="text-muted text-center small mt-3 mb-0">
                            <i class="bi bi-lock me-1"></i>Paiement 100% sécurisé
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include('inc/footer.inc.php'); ?>
</body>
</html>
