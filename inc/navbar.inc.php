<!-- Navbar -->
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
                    <a class="nav-link <?php echo ($currentPage ?? '') === 'index' ? 'active' : ''; ?>" href="index.php">
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
                <a href="login.php" class="nav-icon-link" title="Mon compte">
                    <i class="bi bi-person-circle"></i>
                </a>
            </div>
        </div>
    </div>
</nav>
