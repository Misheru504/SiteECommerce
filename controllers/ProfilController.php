<?php

class ProfilController
{
    /**
     * Affiche la page du profil
     *
     * @param array<string, mixed> $params Paramètres GET
     * @return void
     */
    public static function showProfilePage(array $params): void
    {
        AuthentificationController::requireAuthentification();

        $pageTitle = 'Mon Profil';
        $currentPage = 'profil';
        $activeTab = $params['tab'] ?? 'orders';
        $currentUserId = $_SESSION['user_id'];

        $user = DatabaseManager::sendRequest('SELECT idclient, nomclient, prenomclient, mailclient, numerotelclient, adresse, ville, codepostal, dateinscription FROM v_Users WHERE IdClient = ?', [$currentUserId])[0];
        $commandesArray = DatabaseManager::sendRequest('SELECT idCommande, dateCommande, dateLivraison FROM Commande WHERE idClient = ? ORDER BY dateCommande DESC;', [$currentUserId]);
        $commandes = [];
        foreach ($commandesArray as $commande)
        {
            $commandes[] = new Commande($commande);
        }

        require('views/ProfilView.php');
    }
}
