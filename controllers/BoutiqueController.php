<?php

class BoutiqueController
{
    /**
     * Affiche la boutique du site
     *
     * @param array<string, mixed> $params Liste des paramètres GET
     * @return void
     */
    public static function showShopPage(array $params): void
    {
        AuthentificationController::requireAuthentification();

        $pageTitle = 'Boutique';
        $currentPage = 'boutique';

        $filterCategory = $params['cat'] ?? 'all';
        $filterTheme = $params['theme'] ?? 'all';
        $filteredProducts = ProduitManager::getAllProduits();

        if ($filterCategory !== 'all')
        {
            $filteredProducts = array_filter($filteredProducts, fn($p) => $p->getType() == $filterCategory);
        }
        if ($filterTheme !== 'all')
        {
            $filteredProducts = array_filter($filteredProducts, fn($p) => $p->getFranchise() == $filterTheme);
        }

        $themes = ProduitManager::getFranchises();

        require ROOT_PATH . '/views/BoutiqueView.php';
    }
}