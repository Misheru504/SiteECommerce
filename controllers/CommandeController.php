<?php

class CommandeController
{
    /**
     * Affiche la page de commande du panier d'un utilisateur
     *
     * @param array<string, mixed> $params Paramètres GET
     * @return void
     */
    public static function showCommandePage(array $params)
    {
        $currentPage = 'commande';
        $pageTitle = 'Commande';
        if(AuthentificationController::isConnected()) $nbPanier = PanierManager::getPanierCountFromClient($_SESSION['user_id']);

        require  ROOT_PATH . '/views/CommandeView.php';
    }
}