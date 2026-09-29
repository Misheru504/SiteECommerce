<?php
/**
 * @var $pageTitle string Titre de la page
 * @var $currentPage string Page actuelle
 * @var $errorMessage ?string Message d'erreur
 */
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php include('inc/header.inc.php'); ?>
    </head>
    <body>
    <?php include('inc/navbar.inc.php'); ?>

    <section class="py-5">
        <div class="auth-container">
            <div class="auth-card">
                <h2><i class="bi bi-person-plus text-orange"></i></h2>
                <h2>Inscription</h2>
                <p class="auth-subtitle">Rejoignez la communauté Brique-à-Brac !</p>

                <?php if(isset($errorMessage)): ?>
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <span><?php echo $errorMessage ?></span>
                </div>
                <?php endif; ?>

                <div class="row g-3">
                    <div class="col-6">
                        <label for="firstname" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="firstname" placeholder="Jean">
                    </div>
                    <div class="col-6">
                        <label for="lastname" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="lastname" placeholder="Dupont">
                    </div>
                </div>

                <div class="mb-3 mt-3">
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <input type="email" class="form-control" id="email" placeholder="jean@exemple.fr">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" placeholder="Minimum 8 caractères">
                </div>

                <div class="mb-3">
                    <label for="password_confirm" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" class="form-control" id="password_confirm" placeholder="Retapez le mot de passe">
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="cgu">
                    <label class="form-check-label small" for="cgu">
                        J'accepte les <a href="#">conditions générales</a> d'utilisation
                    </label>
                </div>

                <button class="btn btn-auth">
                    <i class="bi bi-person-check me-2"></i>Créer mon compte
                </button>

                <div class="auth-link">
                    Déjà un compte ? <a href="<?php echo BASE_URL . "?controller=Authentification&action=showLoginPage" ?>">Se connecter</a>
                </div>
            </div>
        </div>
    </section>

    <?php include('inc/footer.inc.php'); ?>
    </body>
</html>
