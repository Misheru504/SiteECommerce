<?php
/**
 * @var $pageTitle string Titre de la page
 * @var $currentPage string Page actuelle
 * @var $cartItems array<Produit> Produits du panier de l'utilisateur actuel
 * @var $total int Prix total du panier (livraison inclus)
 * @var $shipping int Coût de la livraison
 * @var $subtotal int Prix du panier (sans la livraison)
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('inc/header.inc.php'); ?>
</head>
<body>
<?php include('inc/navbar.inc.php'); ?>

<!-- Breadcrumb -->
<div class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL?>">Accueil</a></li>
                <li class="breadcrumb-item active">Panier</li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <h2 class="section-title mb-4">Mon panier</h2>

        <?php if (empty($cartItems)): ?>
            <div class="empty-state">
                <i class="bi bi-cart-x d-block"></i>
                <h4>Votre panier est vide</h4>
                <p>Ajoutez des produits pour commencer vos achats.</p>
                <a href="<?php echo BASE_URL . "?controller=Boutique&action=showShopPage"?>" class="btn btn-add-cart">Voir la boutique</a>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <!-- Liste des articles -->
                <div class="col-lg-8">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="cart-item">
                            <div class="cart-item-img">
                                <img class="product-img" src="<?php echo BASE_URL . "/img/" . $item->getId() . ".jpg" ?>" alt="<?php echo $item->getNom(); ?>">
                            </div>
                            <div class="cart-item-info">
                                <div class="cart-item-name">
                                    <a href="<?php echo BASE_URL . "?controller=Produit&action=showProductPage&id=" . $item->getId(); ?>">
                                        <?php echo htmlspecialchars($item->getNom()); ?>
                                    </a>
                                </div>
                                <div class="cart-item-theme"><?php echo htmlspecialchars($item->getFranchise()); ?></div>
                            </div>
                            <div class="cart-quantity">
                                <button class="btn">-</button>
                                <span><?php echo 2; ?></span>
                                <button class="btn">+</button>
                            </div>
                            <div class="cart-item-price">
                                <?php echo number_format(2, 2, ',', ' '); ?> &euro;
                            </div>
                            <a href="#" class="cart-item-remove" title="Supprimer">
                                <i class="bi bi-trash3"></i>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Résumé -->
                <div class="col-lg-4">
                    <div class="cart-summary">
                        <h5>Résumé de la commande</h5>

                        <div class="cart-summary-row">
                            <span>Sous-total</span>
                            <span><?php echo number_format($subtotal, 2, ',', ' '); ?> &euro;</span>
                        </div>
                        <div class="cart-summary-row">
                            <span>Livraison</span>
                            <span>
                                    <?php if ($shipping === 0): ?>
                                        <span class="text-success fw-bold">Gratuite</span>
                                    <?php else: ?>
                                        <?php echo number_format($shipping, 2, ',', ' '); ?> &euro;
                                    <?php endif; ?>
                                </span>
                        </div>

                        <hr>

                        <div class="cart-summary-row cart-summary-total">
                            <span>Total</span>
                            <span><?php echo number_format($total, 2, ',', ' '); ?> &euro;</span>
                        </div>

                        <a href="<?php echo BASE_URL . "?controller=Commande&action=showCommandePage" ?>" class="btn btn-checkout mt-3">
                            <i class="bi bi-credit-card me-2"></i>Passer commande
                        </a>

                        <div class="text-center mt-3">
                            <a href="<?php echo BASE_URL . "?controller=Boutique&action=showShopPage"?>" class="text-muted small">
                                <i class="bi bi-arrow-left me-1"></i>Continuer mes achats
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include('inc/footer.inc.php'); ?>
</body>
</html>
