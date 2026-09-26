<!-- Navbar -->
<?php
/**
 * @var $currentPage string Page actuelle sur la barre de navigation
 */
?>
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <!-- Logo / Nom du site -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <i class="bi bi-bricks me-2"></i>
            <span>Brique-à-Brac</span>
        </a>

        <!-- Bouton hamburger (mobile) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Liens de navigation -->
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage ?? '') === 'accueil' ? 'active' : ''; ?>" href="index.php">
                        <i class="bi bi-house-door me-1"></i>Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage ?? '') === 'boutique' ? 'active' : ''; ?>" href="boutique.php">
                        <i class="bi bi-shop me-1"></i>Boutique
                    </a>
                </li>
            </ul>

            <!-- Icônes à droite -->
            <div class="d-flex align-items-center gap-3">
                <a href="panier.php" class="nav-icon-link position-relative" title="Panier">
                    <i class="bi bi-cart3"></i>
                    <span class="badge-cart">3</span>
                </a>
                <!-- Menu compte (dropdown) -->
                <div class="dropdown">
                    <a href="#" class="nav-icon-link dropdown-toggle" data-bs-toggle="dropdown" title="Mon compte" id="accountDropdown">
                        <i class="bi bi-person-circle"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="profil.php?tab=orders">
                                <i class="bi bi-bag-check me-2"></i>Mes commandes
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="profil.php?tab=info">
                                <i class="bi bi-person-gear me-2"></i>Mes informations
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="login.php">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Connexion
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="register.php">
                                <i class="bi bi-person-plus me-2"></i>Inscription
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
