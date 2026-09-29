<?php
/**
 * @var $pageTitle string Titre de la page
 * @var $currentPage string Page actuelle du site
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
                <form action="<?php echo BASE_URL . "/index.php?controller=Authentification&action=attemptLogin"?>" method="POST">
                    <div class="auth-card">
                        <h2><i class="bi bi-person-circle text-orange"></i></h2>
                        <h2>Connexion</h2>
                        <p class="auth-subtitle">Accédez à votre compte Brique-à-Brac</p>

                        <?php if(isset($errorMessage)): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <span><?php echo $errorMessage ?></span>
                        </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse e-mail</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="jean@exemple.fr">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Votre mot de passe">
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember">
                                <label class="form-check-label small" for="remember">Se souvenir de moi</label>
                            </div>
                            <a href="#" class="small">Mot de passe oublié ?</a>
                        </div>

                        <button type="submit" class="btn btn-auth">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                        </button>

                        <div class="auth-link">
                            Pas encore de compte ? <a href="<?php echo BASE_URL . "?controller=Authentification&action=showRegisterPage"?>">Créer un compte</a>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <?php include('inc/footer.inc.php'); ?>
    </body>
</html>