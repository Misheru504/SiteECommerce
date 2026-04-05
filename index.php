<?php
$currentPage = 'index';
$pageTitle = 'Accueil';

include('inc/products_data.inc.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('inc/header.inc.php'); ?>
</head>
<body>
    <?php include('inc/navbar.inc.php'); ?>

    <!-- Hero Banner -->
    <section class="hero">
        <div class="container">
            <h1>Bienvenue chez Brique-à-Brac</h1>
            <p>Votre boutique en ligne de sets et figurines LEGO. Trouvez les briques de vos rêves !</p>
            <a href="boutique.php" class="btn btn-hero">
                <i class="bi bi-shop me-2"></i>Voir la boutique
            </a>
        </div>
    </section>

    <!-- Promos -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">Promotions du moment</h2>
            <p class="section-subtitle">Profitez de nos offres avant qu'il ne soit trop tard !</p>
            <hr class="section-divider">

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                <?php foreach (getPromoProducts($productsFromBDD) as $product): ?>
                    <?php include('inc/product_card.inc.php'); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Promo Banner -->
    <section class="py-4">
        <div class="container">
            <div class="promo-banner">
                <span class="badge-discount">-15%</span>
                <h3 class="mt-2">Offre spéciale Star Wars</h3>
                <p class="mb-3 opacity-75">Avec le code <strong>FORCE15</strong> sur toute la gamme Star Wars !</p>
                <a href="boutique.php" class="btn btn-hero">En profiter</a>
            </div>
        </div>
    </section>

    <!-- Avantages -->
    <section class="py-5 bg-orange-light">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <i class="bi bi-truck text-orange" style="font-size: 2.5rem;"></i>
                    <h5 class="mt-2 fw-bold">Livraison gratuite</h5>
                    <p class="text-muted mb-0">Dès 50&euro; d'achat en France métropolitaine</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-shield-check text-orange" style="font-size: 2.5rem;"></i>
                    <h5 class="mt-2 fw-bold">Paiement sécurisé</h5>
                    <p class="text-muted mb-0">Vos transactions sont 100% protégées</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-arrow-repeat text-orange" style="font-size: 2.5rem;"></i>
                    <h5 class="mt-2 fw-bold">Retours sous 30 jours</h5>
                    <p class="text-muted mb-0">Satisfait ou remboursé, sans condition</p>
                </div>
            </div>
        </div>
    </section>

    <?php include('inc/footer.inc.php'); ?>
</body>
</html>
