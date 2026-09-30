<?php

class PanierManager
{
    /**
     * Récupère le panier d'un client dans la base de données
     *
     * @param int $clientId Identifiant du client
     * @return array<int, int> Tableau du panier (idProduit -> quantité)
     */
    public static function getPanierFromClient(int $clientId): array
    {
        $sql = 'SELECT idProduit, qte FROM Panier WHERE idClient = ?';
        $result = DatabaseManager::sendRequest($sql, [$clientId]);
        $cart = [];

        foreach ($result as $row => $value)
        {
            $cart[$value["idProduit"]] = (int)$value["qte"];
        }
        return $cart;
    }

    /**
     * Compte le nombre d'articles dans le panier d'un client
     *
     * @param int $clientId Identifiant du client
     * @return int Nombre d'article dans le panier
     */
    public static function getPanierCountFromClient(int $clientId): int
    {
        $sql = 'SELECT SUM(qte) AS nbProduits FROM Panier WHERE idClient = ?';
        return (int) (DatabaseManager::sendRequest($sql, [$clientId])[0]["nbProduits"]);
    }
}
