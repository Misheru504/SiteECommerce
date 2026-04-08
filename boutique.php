<?php
$currentPage = 'boutique';
$pageTitle = 'Boutique';
include('inc/products_data.inc.php');

// Filtrage simple par catégorie (GET)
$filterCategory = $_GET['cat'] ?? 'all';
$filterTheme = $_GET['theme'] ?? 'all';

ProduitsData::connexion();
$filteredProducts = ProduitsData::getAllProduits();

if ($filterCategory !== 'all') {
    /** @var Produit $p */
    $filteredProducts = array_filter($filteredProducts, fn($p) => $p->getType() == $filterCategory);
}
if ($filterTheme !== 'all') {

    /** @var Produit $p */
    $filteredProducts = array_filter($filteredProducts, fn($p) => $p->getFranchise() == $filterTheme);
}

$themes = ProduitsData::getFranchises();
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
                    <li class="breadcrumb-item active">Boutique</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Boutique -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">Notre catalogue</h2>
            <p class="section-subtitle">Parcourez notre sélection de sets et figurines</p>
            <hr class="section-divider">

            <!-- Filtres catégorie -->
            <div class="d-flex flex-wrap gap-2 mb-3">
                <a href="boutique.php" class="filter-btn <?php echo $filterCategory === 'all' && $filterTheme === 'all' ? 'active' : ''; ?>">
                    Tout
                </a>
                <a href="boutique.php?cat=Set" class="filter-btn <?php echo $filterCategory === 'Set' ? 'active' : ''; ?>">
                    <i class="bi bi-box me-1"></i>Sets
                </a>
                <a href="boutique.php?cat=Figurine" class="filter-btn <?php echo $filterCategory === 'Figurine' ? 'active' : ''; ?>">
                    <i class="bi bi-person-standing me-1"></i>Figurines
                </a>
            </div>

            <!-- Filtres thème -->
            <div class="d-flex flex-wrap gap-2 mb-4">
                <?php foreach ($themes as $theme): ?>
                    <a href="boutique.php?theme=<?php echo urlencode($theme); ?>"
                       class="filter-btn <?php echo $filterTheme === $theme ? 'active' : ''; ?>"
                       style="font-size: 0.8rem; padding: 0.3rem 0.9rem;">
                        <?php echo htmlspecialchars($theme); ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Nombre de résultats -->
            <p class="text-muted mb-4">
                <strong><?php echo count($filteredProducts); ?></strong> produit(s) trouvé(s)
            </p>

            <!-- Grille produits -->
            <?php if (!empty($filteredProducts)): ?>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">
                    <?php foreach ($filteredProducts as $product): ?>
                        <?php include('inc/product_card.inc.php'); ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="bi bi-search d-block"></i>
                    <h4>Aucun produit trouvé</h4>
                    <p>Essayez de modifier vos filtres.</p>
                    <a href="boutique.php" class="btn btn-add-cart">Voir tout</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include('inc/footer.inc.php'); ?>
</body>
</html>
