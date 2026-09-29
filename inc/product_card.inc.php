<?php
/**
 * @var Produit $product
 */
?>
<div class="col">
    <div class="card product-card h-100">
        <?php if ($product->getPromo() != 0): ?>
            <span class="badge-promo">PROMO</span>
        <?php endif; ?>

        <!-- Image placeholder -->
        <a href="<?php echo BASE_URL . "?controller=Produit&action=showProductPage&id=" . $product->getId(); ?>">
            <img class="product-img" src="img/<?php echo $product->getId(); ?>.jpg" alt="<?php echo $product->getNom(); ?>">
        </a>

        <div class="card-body d-flex flex-column">
            <!-- Thème -->
            <span class="product-theme"><?php echo $product->getFranchise(); ?></span>

            <!-- Nom -->
            <h5 class="product-name">
                <a href="<?php echo BASE_URL . "?controller=Produit&action=showProductPage&id=" . $product->getId(); ?>">
                    <?php echo $product->getNom(); ?>
                </a>
            </h5>

            <!-- Infos -->
            <div class="product-meta">
                    <span><i class="bi bi-puzzle me-1"></i><?php echo $product->getNbPieces(); ?> pièces</span>
                <span><i class="bi bi-person me-1"></i><?php echo $product->getAge(); ?></span>
            </div>

            <!-- Prix -->
            <div class="product-price mt-auto">
                <?php if ($product->getPromo() != 0): ?>
                    <span class="old-price"><?php echo $product->getOldPrice(); ?> &euro;</span>
                <?php endif; ?>
                <span class="current-price"><?php echo $product->getPrix(); ?> &euro;</span>
            </div>

            <!-- Bouton -->
            <a href="<?php echo BASE_URL . "?controller=Panier&action=add&id=" . $product->getId(); ?>" class="btn btn-add-cart mt-2">
                <i class="bi bi-cart-plus me-1"></i>Ajouter au panier
            </a>
        </div>
    </div>
</div>