<?php

class PanierController
{
    /**
     * Affiche le panier d'un utilisateur
     *
     * @param array<string, mixed> $params Paramètres GET
     * @return void
     */
    public static function showCartPage(array $params): void
    {
        AuthentificationController::requireAuthentification();

        $pageTitle = 'Mon Panier';
        $currentPage = 'panier';

        /**
         * Panier en dur pour la maquette.
         * À remplacer par $_SESSION['cart'] quand la BDD sera en place.
         * Structure : id produit => quantité
         */

        $cart = [
            1 => 1,   // Millennium Falcon
            2 => 2,   // Iron Man MK50
        ];

        $cartItems = [];
        $subtotal = 0;

        require_once 'models/Produit.php';
        require_once 'models/ProduitManager.php';
        require_once 'models/DatabaseManager.php';

        foreach ($cart as $productId => $qty) {
            $p = ProduitManager::getProduitById($productId);
            if ($p) {
                $total = (int) $p->getPrix() * $qty;
                $cartItems[] = $p;
                $subtotal += $total;
            }
        }


        $shipping = $subtotal >= 50 ? 0 : 5.99;
        $total = $subtotal + $shipping;

        require "views/PanierView.php";
    }

    /**
     * Ajoute un article au panier
     *
     * @param array<string, mixed> $params Paramètres GET
     * @return void
     */
    public static function add(array $params): void
    {
        AuthentificationController::requireAuthentification();

        // TODO: ADD ARTICLES

        self::redirectToCart("Article ajoutée");
    }

    /**
     * Réduit/Supprime un article du panier
     *
     * @param array<string, mixed> $params Paramètres GET
     * @return void
     */
    public static function remove(array $params): void
    {
        AuthentificationController::requireAuthentification();

        // TODO: Remove articles

        self::redirectToCart("Article supprimé");
    }

    /**
     * Redirige l'utilisateur vers la page de son panier
     *
     * @param string|null $message Message d'information (optionel)
     * @return void
     */
    public static function redirectToCart(?string $message = null): void
    {
        header("Location: " . BASE_URL . "?controller=Panier&action=showCartPage" . (isset($message) ? "&message=" . $message : null));
        exit;
    }
}