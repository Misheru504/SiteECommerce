<?php

class HomeController
{
    /**
     * Affiche la page principale du site
     *
     * @param array<string, mixed> $params Liste des paramètres GET
     * @return void
     */
    public static function showMainPage(array $params): void
    {
        $pageTitle = "Accueil";
        $currentPage = "accueil";
        if(AuthentificationController::isConnected()) $nbPanier = PanierManager::getPanierCountFromClient($_SESSION['user_id']);

        $produitsEnPromo = ProduitManager::getProduitsEnPromotion();

        require ROOT_PATH . '/views/HomeView.php';
    }
}