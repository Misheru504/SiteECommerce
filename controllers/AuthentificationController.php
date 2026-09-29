<?php

class AuthentificationController
{
    /**
     * Affiche la page de connexion du site
     *
     * @param array<string, mixed> $params Paramètres GET
     * @return void
     */
    public static function showLoginPage(array $params): void
    {
        $pageTitle = 'Connexion';
        $currentPage = 'login';
        $errorMessage = $params['error'] ?? null;

        require ROOT_PATH . '/views/LoginView.php';
    }

    /**
     * Affiche la page d'inscription du site
     *
     * @param array<string, mixed> $params Paramètres GET
     * @return void
     */
    public static function showRegisterPage(array $params): void
    {
        $pageTitle = 'Inscription';
        $currentPage = 'register';
        $errorMessage = $params['error'] ?? null;

        require ROOT_PATH . '/views/RegisterView.php';
    }

    /**
     * Effectue une tentative de connexion au site. En cas d'echec, l'utilisateur est renvoyé sur la page de connexion<br>
     * <b>Remarque : le login et le mot de passe doivent être passer à cette action par une requête POST</b>
     *
     * @param array<string, mixed> $params Paramètres GET
     * @return void
     */
    public static function attemptLogin(array $params): void
    {
        $errorMessage = null;

        if(!empty($_POST)){
            if(!empty($_POST['password']) && !empty($_POST['email'])) {

                $isConnected = AuthentificationManager::attemptLogin($_POST['email'], $_POST['password']);

                if (!$isConnected) {
                    $errorMessage = 'Adresse mail ou mot de passe incorrect!';
                } else {
                    $_SESSION['user_id'] = $isConnected;
                    header("Location: " . BASE_URL . "?controller=Profil&action=showProfilePage&tab=orders");
                    exit;
                }
            }
            else
            {
                $errorMessage = 'Le formulaire est incomplet !';
            }
        }

        self::redirectToLogin($errorMessage);
    }

    /**
     * Vérifie si l'utilisateur est connecté, sinon l'utilisateur est redirigé vers la page de connexion
     * @return void
     */
    public static function requireAuthentification(): void
    {
        if(!self::isConnected())
        {
            self::redirectToLogin();
        }
    }

    /**
     * Déconnecte un utilisateur et affiche la page de connexion
     *
     * @return void
     */
    public static function logout(): void
    {
        unset($_SESSION['user_id']);
        session_regenerate_id(true);

        self::redirectToLogin();
    }

    /**
     * Vérifie si un utilisateur est connecté
     *
     * @return bool True si un utilisateur est connecté | Faux si aucun utilisateur n'est connecté
     */
    public static function isConnected(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Redirige l'utilisateur vers la page de connexion
     *
     * @param string|null $errorMessage Message d'erreur (optionel)
     * @return void
     */
    public static function redirectToLogin(?string $errorMessage = null): void
    {
        header("Location: " . BASE_URL . "?controller=Authentification&action=showLoginPage" . (isset($errorMessage) ? "&error=" . $errorMessage : null));
        exit;
    }
}