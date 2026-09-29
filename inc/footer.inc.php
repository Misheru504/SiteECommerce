<footer class="site-footer mt-auto">
    <div class="container">
        <div class="row gy-4">
            <!-- Colonne marque -->
            <div class="col-lg-4 col-md-6">
                <h5 class="footer-brand">
                    <i class="bi bi-bricks me-2"></i>Brique-à-Brac
                </h5>
                <p class="mb-0">
                    Votre boutique en ligne de sets et figurines LEGO.
                    Des briques, de la passion, et des prix sympas !
                </p>
            </div>

            <!-- Colonne navigation -->
            <div class="col-lg-2 col-md-6">
                <h6 class="footer-title">Navigation</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="<?php echo BASE_URL ?>">Accueil</a></li>
                    <li><a href="<?php echo BASE_URL . "?controller=Boutique&action=showShopPage" ?>">Boutique</a></li>
                    <li><a href="<?php echo BASE_URL . "?controller=Panier&action=showCartPage"?>">Panier</a></li>
                </ul>
            </div>

            <!-- Colonne compte -->
            <div class="col-lg-2 col-md-6">
                <h6 class="footer-title">Mon compte</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="<?php echo BASE_URL . "?controller=Authentification&action=showLoginPage" ?>">Connexion</a></li>
                    <li><a href="<?php echo BASE_URL . "?controller=Authentification&action=showRegisterPage" ?>">Inscription</a></li>
                    <li><a href="<?php echo BASE_URL . "?controller=Profil&action=showProfilePage&tab=info" ?>">Mon profil</a></li>
                    <li><a href="<?php echo BASE_URL . "?controller=Profil&action=showProfilePage&tab=orders" ?>">Mes commandes</a></li>
                </ul>
            </div>

            <!-- Colonne contact -->
            <div class="col-lg-4 col-md-6">
                <h6 class="footer-title">Contact</h6>
                <ul class="list-unstyled footer-links">
                    <li><i class="bi bi-envelope me-2"></i>contact@brique-a-brac.fr</li>
                    <li><i class="bi bi-telephone me-2"></i>01 23 45 67 89</li>
                    <li><i class="bi bi-geo-alt me-2"></i>42 Rue des Briques, Paris</li>
                </ul>
            </div>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
            <p class="mb-0 small">&copy; <?php echo date('Y'); ?> Brique-à-Brac - Projet BTS SIO</p>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
