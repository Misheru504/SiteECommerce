<?php

class ProduitManager
{
    /**
     * Renvoi la liste de tous les produits, triés par leurs identifiants
     *
     * @return array<Produit> Liste d'objet Produit
     */
    public static function getAllProduits(): array
    {
        $sql = 'SELECT * FROM v_Produits ORDER BY IdProduit';
        $result = DatabaseManager::sendRequest($sql);
        return self::parseSqlDansArray($result);
    }

    /**
     * Retourne un produit par son identifiant, ou null si rien n'est trouvé
     *
     * @param int $id Identifiant du produit à chercher
     * @return Produit|null Produit avec l'identifiant correspondant | null si aucun résultat
     */
    public static function getProduitById(int $id): ?Produit
    {
        $sql = 'SELECT * FROM v_Produits WHERE IdProduit = ?';
        $result = DatabaseManager::sendRequest($sql, [$id]);

        return !empty($result) ? new Produit($result[0]) : null;
    }

    /**
     * Retourne la liste des produits d'une franchise
     *
     * @param string $franchise Nom de la franchise
     * @return array<Produit> Liste des produits de la franchise correspondante
     */
    public static function getProduitsByFranchise(string $franchise): array
    {
        $sql = 'SELECT * FROM v_Produits WHERE Franchise = ?';
        $result = DatabaseManager::sendRequest($sql, [$franchise]);

        return self::parseSqlDansArray($result);
    }

    /**
     * Retourne la liste des produits d'un type de produit
     *
     * @param string $type Nom du type des produit
     * @return array<Produit> Liste des produits avec le type correspondant
     */
    public static function getProduitsByType(string $type): array
    {
        $sql = 'SELECT * FROM v_Produits WHERE Type = ?';
        $result = DatabaseManager::sendRequest($sql, [$type]);

        return self::parseSqlDansArray($result);
    }

    /**
     * Retourne la liste des produits d'un type de produit et d'une franchise
     *
     * @param string $type Nom du type de produit
     * @param string $franchise Nom de la franchise du produit
     * @return array<Produit> Liste des produits avec le type et la franchise correspondant
     */
    public static function getProduitsByTypeAndFranchise(string $type, string $franchise): array
    {
        $sql = 'SELECT * FROM v_Produits WHERE Type = ? AND Franchise = ?';
        $result = DatabaseManager::sendRequest($sql, [$type]);

        return self::parseSqlDansArray($result);
    }

    /**
     * Retourne la liste des produits de la même franchise que le produit passé en paramètre (ne l'inclut pas dans le résultat)
     *
     * @param Produit $produit Produit de départ
     * @return array<Produit> Liste des produits avec la même franchise
     */
    public static function getProduitsSimilaire(Produit $produit): array
    {
        $sql = 'SELECT * FROM v_Produits WHERE Franchise = ? AND IdProduit != ?';
        $result = DatabaseManager::sendRequest($sql, [$produit->getFranchise(), $produit->getId()]);

        return self::parseSqlDansArray($result);
    }

    /**
     * Retourne la liste des produits en promotion
     * TODO: REFAIRE LES PROMOTIONS (TABLE SÉPARÉE)
     *
     * @return array<Produit> Liste des produits actuellement en promotion
     */
    public static function getProduitsEnPromotion(): array
    {
        $sql = 'SELECT * FROM v_Produits WHERE Promotion != 0';
        $result = DatabaseManager::sendRequest($sql);

        return self::parseSqlDansArray($result);
    }

    /**
     * Retourne la liste des franchises
     *
     * @return array<string> Liste des franchises
     */
    public static function getFranchises(): array
    {
        $sql = 'SELECT distinct Franchise FROM v_Produits';
        return array_column(DatabaseManager::sendRequest($sql), 'Franchise');
    }

    /**
     * Transforme un tableau SQL en liste d'objet Produit
     *
     * @param array $produits Tableau SQL des produits
     * @return array<string, string> Liste d'objets Produit
     */
    private static function parseSqlDansArray(array $produits): array
    {
        $listeProduits = [];
        if(!empty($produits))
        {
            foreach($produits as $produit)
            {
                $listeProduits[] = new Produit($produit);
            }
        }

        return $listeProduits;
    }
}