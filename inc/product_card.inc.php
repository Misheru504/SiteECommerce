<?php
/**
 * Carte produit réutilisable.
 * Attend une variable $product (tableau associatif).
 * Usage : inclure ce fichier après avoir défini $product.
 */

require_once './class/Produit.class.php';

$productObj = new Produit($product);
?>
<div class="col">
    <div class="card product-card h-100">
        <?php if ($productObj->getPromo() != 0): ?>
            <span class="badge-promo">PROMO</span>
        <?php endif; ?>

        <!-- Image placeholder -->
        <a href="produit.php?id=<?php echo $productObj->getId(); ?>">
            <div class="product-img-placeholder">
                <span class="placeholder-text"><?php echo $productObj->getNbPieces(); ?> pcs</span>
            </div>
        </a>

        <div class="card-body d-flex flex-column">
            <!-- Thème -->
            <span class="product-theme"><?php echo $productObj->getFranchise(); ?></span>

            <!-- Nom -->
            <h5 class="product-name">
                <a href="produit.php?id=<?php echo $productObj->getId(); ?>">
                    <?php echo $productObj->getNom(); ?>
                </a>
            </h5>

            <!-- Infos -->
            <div class="product-meta">
                    <span><i class="bi bi-puzzle me-1"></i><?php echo $productObj->getNbPieces(); ?> pièces</span>
                <span><i class="bi bi-person me-1"></i><?php echo $productObj->getAge(); ?></span>
            </div>

            <!-- Prix -->
            <div class="product-price mt-auto">
                <?php if ($productObj->getPromo() != 0): ?>
                    <span class="old-price"><?php echo $productObj->getOldPrice(); ?> &euro;</span>
                <?php endif; ?>
                <span class="current-price"><?php echo $productObj->getPrix(); ?> &euro;</span>
            </div>

            <!-- Bouton -->
            <a href="panier.php?add=<?php echo $productObj->getId(); ?>" class="btn btn-add-cart mt-2">
                <i class="bi bi-cart-plus me-1"></i>Ajouter au panier
            </a>
        </div>
    </div>
</div>