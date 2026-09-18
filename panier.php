<?php
$currentPage = 'panier';
$pageTitle = 'Mon Panier';
include('inc/products_data.inc.php');

/**
 * Panier en dur pour la maquette.
 * À remplacer par $_SESSION['cart'] quand la BDD sera en place.
 * Structure : id produit => quantité
 */
$cart = [
    1 => 1,   // Millennium Falcon
    2 => 2,   // Iron Man MK50
];

// Calculer les totaux
$cartItems = [];
$subtotal = 0;

ProduitsData::connexion();

foreach ($cart as $productId => $qty) {
    $p = ProduitsData::getProduitById($productId);
    if ($p) {
        $p['qty'] = $qty;
        $p['total'] = $p['Prix'] * $qty;
        $cartItems[] = $p;
        $subtotal += $p['total'];
    }
}

$shipping = $subtotal >= 50 ? 0 : 5.99;
$total = $subtotal + $shipping;
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
                    <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
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
                    <a href="boutique.php" class="btn btn-add-cart">Voir la boutique</a>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <!-- Liste des articles -->
                    <div class="col-lg-8">
                        <?php foreach ($cartItems as $item): ?>
                            <div class="cart-item">
                                <div class="cart-item-img">
                                    <span class="placeholder-text" style="font-size: 0.7rem;">IMG</span>
                                </div>
                                <div class="cart-item-info">
                                    <div class="cart-item-name">
                                        <a href="produit.php?id=<?php echo $item['IdProduit']; ?>">
                                            <?php echo htmlspecialchars($item['NomProduit']); ?>
                                        </a>
                                    </div>
                                    <div class="cart-item-theme"><?php echo htmlspecialchars($item['Franchise']); ?></div>
                                </div>
                                <div class="cart-quantity">
                                    <button class="btn">-</button>
                                    <span><?php echo $item['qty']; ?></span>
                                    <button class="btn">+</button>
                                </div>
                                <div class="cart-item-price">
                                    <?php echo number_format($item['total'], 2, ',', ' '); ?> &euro;
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

                            <a href="commande.php" class="btn btn-checkout mt-3">
                                <i class="bi bi-credit-card me-2"></i>Passer commande
                            </a>

                            <div class="text-center mt-3">
                                <a href="boutique.php" class="text-muted small">
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
