<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'utils/DBUser.class.php';
$db = new DBUser('site', 'P@ssw0rd');
$db->getBddConnexion();
$sql = 'SELECT * FROM v_Produits ORDER BY NomProduit';
$productsFromBDD = $db->sendRequest($sql);

// === Fonctions utilitaires ===

/**
 * Retrouver un produit par son ID
 */
function getProductById(int $id, array $products): ?array {
    foreach ($products as $product) {
        if ($product['IdProduit'] === $id) {
            return $product;
        }
    }
    return null;
}

/**
 * Filtrer les produits par catégorie
 */
function getProductsByCategory(string $category, array $products): array {
    return array_filter($products, fn($p) => $p['category'] === $category);
}

/**
 * Récupérer les produits en promo
 */
function getPromoProducts(array $products): array {
    return array_filter($products, fn($p) => $p['Promotion'] != 0.00);
}

/**
 * Récupérer les produits mis en avant
 */
function getFeaturedProducts(array $products): array {
    return array_filter($products, fn($p) => $p['featured'] === true);
}

/**
 * Récupérer les thèmes uniques
 */
function getUniqueFranchises(array $products): array {
    $themes = array_unique(array_column($products, 'Franchise'));
    return $themes;
}
