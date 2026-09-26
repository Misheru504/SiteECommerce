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
        ProduitsData::connexion();
        $produitsEnPromo = ProduitsData::getProduitsEnPromotion();

        $pageTitle = "Accueil";
        $currentPage = "accueil";

        require ROOT_PATH . '/views/HomeView.php';
    }
}