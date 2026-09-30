<?php

class CommandeManager
{
    /**
     * Récupère les commandes d'un client dans la base de données
     *
     * @param int $idClient Identifiant du client
     * @return array<Commande> Liste des commandes
     */
    public static function getCommandesFromClient(int $idClient): array
    {
        $getCommandes = "SELECT idCommande, dateCommande, dateLivraison FROM Commande C WHERE idClient = ?";
        $commandesRaw = DatabaseManager::sendRequest($getCommandes, [$idClient]);
        $commandes = [];
        foreach ($commandesRaw as $cmdRaw)
        {
            $getProduits = "SELECT idProduit, qte FROM DetailCommande WHERE idCommande = ?";
            $produitsRaw = DatabaseManager::sendRequest($getProduits, [$cmdRaw["idCommande"]]);
            $produits = [];
            $qtes = [];

            foreach ($produitsRaw as $prdRaw => $value)
            {
                $produits[] = ProduitManager::getProduitById($value["idProduit"]);
                $qtes[$value["idProduit"]] = (int)$value["qte"];
            }
            $commandes[] = new Commande($cmdRaw["idCommande"], $idClient, $cmdRaw['dateCommande'], $cmdRaw['dateLivraison'], $qtes, $produits);
        }

        return $commandes;
    }
}
