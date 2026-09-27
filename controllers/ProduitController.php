<?php

class ProduitController
{
    /**
     * Affiche la page d'un produit du site
     *
     * @param array<string, mixed> $params Liste des paramètres GET
     * @return void
     */
    public static function showProductPage(array $params): void
    {
        $currentPage = 'produit';

        // Récupérer l'ID du produit
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        $produitObj = ProduitManager::getProduitById($id);

        if (!$produitObj) {
            $pageTitle = 'Produit introuvable';
        } else {
            $pageTitle = $produitObj->getNom();
            $similaire = ProduitManager::getProduitsSimilaire($produitObj);
        }

        require ROOT_PATH . '/views/ProduitView.php';
    }
}