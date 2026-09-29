<?php
/**
 * @var $pageTitle string Titre de la page
 * @var $currentPage string Page navbar
 * @var $produitObj Produit Produit de la page
 * @var $id int Identifiant du produit de la page
 * @var $similaire array<Produit> Produit similaire au produit actuel
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
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "?controller=Boutique&action=showShopPage"?>">Boutique</a></li>
                <li class="breadcrumb-item active"><?php echo $pageTitle; ?></li>
            </ol>
        </nav>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <?php if (!$produitObj): ?>
            <div class="empty-state">
                <i class="bi bi-emoji-frown d-block"></i>
                <h4>Produit introuvable</h4>
                <p>Ce produit n'existe pas ou a été retiré.</p>
                <a href="<?php echo BASE_URL . "?controller=Boutique&action=showShopPage"?>" class="btn btn-add-cart">Retour à la boutique</a>
            </div>
        <?php else: ?>
            <div class="row g-5">
                <!-- Image -->
                <div class="col-lg-6">
                    <img class="product-img" src="img/<?php echo $produitObj->getId(); ?>.jpg" alt="<?php echo $produitObj->getNom(); ?>">
                </div>

                <!-- Infos -->
                <div class="col-lg-6 product-detail-info">
                    <span class="product-theme"><?php echo $produitObj->getFranchise(); ?></span>
                    <h1 class="product-name"><?php echo $produitObj->getNom(); ?></h1>

                    <!-- Prix -->
                    <div class="product-price mb-3">
                        <?php if ($produitObj->getPromo() != 0): ?>
                            <span class="old-price" style="font-size: 1.1rem;">
                                    <?php echo $produitObj->getOldPrice(); ?> &euro;
                                </span>
                        <?php endif; ?>
                        <span class="current-price" style="font-size: 1.75rem;">
                                <?php echo $produitObj->getPrix(); ?> &euro;
                            </span>
                        <?php if ($produitObj->getPromo() != 0): ?>
                            <span class="badge bg-danger ms-2">PROMO</span>
                        <?php endif; ?>
                    </div>

                    <!-- Description -->
                    <p class="product-description">
                        <?php echo $produitObj->getDescription(); ?>
                    </p>

                    <!-- Spécifications -->
                    <div class="product-specs">
                        <div class="product-spec">
                            <i class="bi bi-puzzle"></i>
                            <span><?php echo $produitObj->getNbPieces(); ?> pièces</span>
                        </div>
                        <div class="product-spec">
                            <i class="bi bi-person"></i>
                            <span>Âge : <?php echo $produitObj->getAge(); ?></span>
                        </div>
                        <div class="product-spec">
                            <i class="bi bi-tag"></i>
                            <span><?php echo $produitObj->getFranchise(); ?></span>
                        </div>
                    </div>

                    <!-- Ajouter au panier -->
                    <a href="<?php echo BASE_URL . "?controller=Panier&action=add&id=" . $produitObj->getId()?>" class="btn btn-add-cart btn-lg w-100">
                        <i class="bi bi-cart-plus me-2"></i>Ajouter au panier
                    </a>
                </div>
            </div>

            <!-- Produits similaires -->
            <?php if (!empty($similaire)): ?>
                <hr class="my-5">
                <h3 class="section-title mb-4">Produits similaires</h3>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                    <?php foreach (array_slice($similaire, 0, 4) as $product): ?>
                        <?php include('inc/product_card.inc.php'); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?php include('inc/footer.inc.php'); ?>
</body>
</html>
