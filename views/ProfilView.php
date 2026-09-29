<?php
/**
 * @var $pageTitle string Titre de la page
 * @var $currentPage string Page actuelle
 * @var $activeTab string Onglet actuel de la page
 * @var $user array<string, mixed> Utilisateur
 * @var $commandes array<Commande> Commandes de l'utilisateur
 */

// Libellés et couleurs pour les statuts
// TODO: Status des commandes dans la BDD
$statusLabels = [
    'pending'   => ['label' => 'En attente',  'class' => 'bg-warning text-dark'],
    'confirmed' => ['label' => 'Confirmée',   'class' => 'bg-info text-white'],
    'shipped'   => ['label' => 'Expédiée',    'class' => 'bg-primary'],
    'delivered' => ['label' => 'Livrée',      'class' => 'bg-success'],
    'cancelled' => ['label' => 'Annulée',     'class' => 'bg-danger'],
];

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
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>">Accueil</a></li>
                    <li class="breadcrumb-item active">Mon profil</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">

                <!-- ===== Sidebar gauche ===== -->
                <div class="col-lg-3">
                    <div class="profile-sidebar">
                        <!-- Avatar + nom -->
                        <div class="profile-avatar-section">
                            <div class="profile-avatar">
                                <?php echo strtoupper($user['PrenomClient'][0] . $user['NomClient'][0]); ?>
                            </div>
                            <h5 class="mt-3 mb-0 fw-bold"><?php echo htmlspecialchars($user['PrenomClient'] . ' ' . $user['NomClient']); ?></h5>
                            <p class="text-muted small mb-0">
                                Membre depuis <?php echo date('F Y', strtotime($user['DateInscription'])); ?>
                            </p>
                        </div>

                        <!-- Navigation profil -->
                        <nav class="profile-nav">
                            <a href="<?php echo BASE_URL . "?controller=Profil&action=showProfilePage&tab=orders"?>" class="profile-nav-link <?php echo $activeTab === 'orders' ? 'active' : ''; ?>">
                                <i class="bi bi-bag-check me-2"></i>Mes commandes
                            </a>
                            <a href="<?php echo BASE_URL . "?controller=Profil&action=showProfilePage&tab=info"?>" class="profile-nav-link <?php echo $activeTab === 'info' ? 'active' : ''; ?>">
                                <i class="bi bi-person-gear me-2"></i>Mes informations
                            </a>
                            <a href="<?php echo BASE_URL . "?controller=Profil&action=showProfilePage&tab=security"?>" class="profile-nav-link <?php echo $activeTab === 'security' ? 'active' : ''; ?>">
                                <i class="bi bi-shield-lock me-2"></i>Sécurité
                            </a>
                            <hr class="my-2">
                            <a href="<?php echo BASE_URL . "?controller=Authentification&action=logout"?>" class="profile-nav-link text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- ===== Contenu principal ===== -->
                <div class="col-lg-9">

                    <?php if ($activeTab === 'orders'): ?>
                        <div class="profile-section">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h3 class="section-title mb-0">Mes commandes</h3>
                                    <p class="text-muted mb-0 small"><?php echo count($commandes); ?> commande(s) passée(s)</p>
                                </div>
                            </div>

                            <?php if (empty($commandes)): ?>
                                <div class="empty-state">
                                    <i class="bi bi-bag-x d-block"></i>
                                    <h4>Aucune commande</h4>
                                    <p>Vous n'avez pas encore passé de commande.</p>
                                    <a href="<?php echo BASE_URL . "?controller=Boutique&action=showShopPage"?>" class="btn btn-add-cart">Voir la boutique</a>
                                </div>
                            <?php else: ?>
                                <?php foreach ($commandes as $commande): ?>
                                    <?php
                                    $produitsCommande = DatabaseManager::sendRequest('SELECT idProduit, qte FROM DetailCommande WHERE idCommande = ?', [$commande->getIdCommande()]);
                                    foreach($produitsCommande as $produit)
                                    {
                                        $produitInfo = DatabaseManager::sendRequest('SELECT * FROM v_Produits WHERE IdProduit = ?', [$produit['idProduit']])[0];
                                        $produitObj = new Produit($produitInfo);
                                        $commande->addProduit($produitObj, $produit['qte']);
                                    }

                                    $statusBool = $commande->estLivrée() ? 'delivered' : 'shipped';

                                    // Calculer le total de la commande
                                    $orderTotal = 0;
                                    $orderItems = [];
                                    foreach ($commande->getProduits() as $item) {
                                        /** @var Produit $pObj */
                                        $pObj = $item['produit'];
                                        $p = [];
                                        $p['produit'] = $item['produit'];
                                        $p['qte'] = (int) $item['qte'];
                                        $p['line_total'] = $pObj->prixUnformatted * (int) $item['qte'];
                                        $orderItems[] = $p;
                                        $orderTotal += $p['line_total'];
                                    }
                                    $status = $statusLabels[$statusBool] ?? $statusLabels['pending'];
                                    ?>
                                    <div class="order-card">
                                        <!-- En-tête commande -->
                                        <div class="order-header">
                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                <span class="order-id">CMD-<?php echo $commande->getIdCommande(); ?></span>
                                                <span class="badge <?php echo $status['class']; ?> rounded-pill">
                                                    <?php echo $status['label']; ?>
                                                </span>
                                            </div>
                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                <span class="text-muted small">
                                                    <i class="bi bi-calendar3 me-1"></i>
                                                    <?php echo date('d/m/Y', strtotime($commande->getDateCommande())); ?>
                                                </span>
                                                <span class="order-total">
                                                    <?php echo number_format($orderTotal, 2, ',', ' '); ?> &euro;
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Articles de la commande -->
                                        <div class="order-items">
                                            <?php foreach ($orderItems as $item): ?>
                                                <?php
                                                /** @var Produit $itemObj */
                                                $itemObj = $item['produit'];
                                                ?>
                                                <div class="order-item">
                                                    <div class="order-item-img">
                                                        <img class="product-img" src="<?php echo BASE_URL . "/img/" . $itemObj->getId() . ".jpg" ?>" alt="<?php echo $itemObj->getNom(); ?>">
                                                    </div>
                                                    <div class="order-item-info">
                                                        <a href="<?php echo BASE_URL . "?controller=Produit&action=showProductPage&id=" . $itemObj->getId() ?>" class="order-item-name">
                                                            <?php echo $itemObj->getNom(); ?>
                                                        </a>
                                                        <span class="order-item-detail">
                                                            <?php echo $itemObj->getFranchise(); ?> — x<?php echo $item['qte']; ?>
                                                        </span>
                                                    </div>
                                                    <div class="order-item-price">
                                                        <?php echo number_format($item['line_total'], 2, ',', ' '); ?> &euro;
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                    <?php elseif ($activeTab === 'info'): ?>
                        <div class="profile-section">
                            <h3 class="section-title mb-1">Mes informations</h3>
                            <p class="text-muted mb-4">Modifiez vos informations personnelles et votre adresse de livraison.</p>

                            <div class="profile-form-card">
                                <h5 class="fw-bold mb-3"><i class="bi bi-person me-2 text-orange"></i>Informations personnelles</h5>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="firstname" class="form-label">Prénom</label>
                                        <input type="text" class="form-control" id="firstname"
                                               value="<?php echo htmlspecialchars($user['PrenomClient']); ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lastname" class="form-label">Nom</label>
                                        <input type="text" class="form-control" id="lastname"
                                               value="<?php echo htmlspecialchars($user['NomClient']); ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Adresse e-mail</label>
                                        <input type="email" class="form-control" id="email"
                                               value="<?php echo htmlspecialchars($user['MailClient']); ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Téléphone</label>
                                        <input type="tel" class="form-control" id="phone"
                                               value="<?php echo htmlspecialchars($user['NumeroTelClient']); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="profile-form-card mt-4">
                                <h5 class="fw-bold mb-3"><i class="bi bi-geo-alt me-2 text-orange"></i>Adresse de livraison</h5>

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="address" class="form-label">Adresse</label>
                                        <input type="text" class="form-control" id="address"
                                               value="<?php echo htmlspecialchars($user['Adresse']); ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="zipcode" class="form-label">Code postal</label>
                                        <input type="text" class="form-control" id="zipcode"
                                               value="<?php echo htmlspecialchars($user['CodePostal']); ?>">
                                    </div>
                                    <div class="col-md-8">
                                        <label for="city" class="form-label">Ville</label>
                                        <input type="text" class="form-control" id="city"
                                               value="<?php echo htmlspecialchars($user['Ville']); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button class="btn btn-add-cart btn-lg px-4">
                                    <i class="bi bi-check-lg me-2"></i>Enregistrer les modifications
                                </button>
                            </div>
                        </div>

                    <?php elseif ($activeTab === 'security'): ?>
                        <div class="profile-section">
                            <h3 class="section-title mb-1">Sécurité</h3>
                            <p class="text-muted mb-4">Modifiez votre mot de passe.</p>

                            <div class="profile-form-card" style="max-width: 500px;">
                                <h5 class="fw-bold mb-3"><i class="bi bi-shield-lock me-2 text-orange"></i>Changer le mot de passe</h5>

                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Mot de passe actuel</label>
                                    <input type="password" class="form-control" id="current_password" placeholder="Votre mot de passe actuel">
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Nouveau mot de passe</label>
                                    <input type="password" class="form-control" id="new_password" placeholder="Minimum 8 caractères">
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe</label>
                                    <input type="password" class="form-control" id="confirm_password" placeholder="Retapez le nouveau mot de passe">
                                </div>

                                <button class="btn btn-add-cart w-100">
                                    <i class="bi bi-check-lg me-2"></i>Modifier le mot de passe
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>

    <?php include('inc/footer.inc.php'); ?>
    </body>
</html>
