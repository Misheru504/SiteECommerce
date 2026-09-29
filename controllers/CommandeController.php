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

        require  ROOT_PATH . '/views/CommandeView.php';
    }
}