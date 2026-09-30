<?php

class ProfilController
{
    /**
     * Affiche la page du profil
     *
     * @param array<string, mixed> $params Paramètres GET
     * @return void
     */
    public static function showProfilePage(array $params): void
    {
        AuthentificationController::requireAuthentification();

        $pageTitle = 'Mon Profil';
        $currentPage = 'profil';
        if(AuthentificationController::isConnected()) $nbPanier = PanierManager::getPanierCountFromClient($_SESSION['user_id']);
        $activeTab = $params['tab'] ?? 'orders';
        $currentUserId = $_SESSION['user_id'];

        $user = ProfilManager::getProfilFromUserId($currentUserId);
        if(!isset($user)) die("Utilisateur introuvable");
        $commandes = CommandeManager::getCommandesFromClient($currentUserId);

        require('views/ProfilView.php');
    }
}
