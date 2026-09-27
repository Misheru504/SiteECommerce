<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'class/DBUser.class.php';
require_once 'class/Produit.class.php';

class ProduitsData
{
    private const LOGIN = 'BAB_app';
    private const PASSWORD = 'P@ssw0rd';
    private static ?DBUser $siteDB = null;

    public static function connexion()
    {
        self::$siteDB = new DBUser(self::LOGIN, self::PASSWORD);
        self::$siteDB->getBddConnexion();
    }

    public static function getAllProduits(): array
    {
        self::isConnected();

        $sql = 'SELECT * FROM v_Produits ORDER BY IdProduit';
        $result = self::$siteDB->sendRequest($sql);
        return self::parseSqlDansArray($result);

    }

    public static function getProduitById(int $id): ?Produit
    {
        self::isConnected();

        $sql = 'SELECT * FROM v_Produits WHERE IdProduit = ?';
        $result = self::$siteDB->sendRequest($sql, [$id]);

        return !empty($result) ? new Produit($result[0]) : null;
    }

    public static function getProduitsByFranchise(string $franchise): array
    {
        self::isConnected();

        $sql = 'SELECT * FROM v_Produits WHERE Franchise = ?';
        $result = self::$siteDB->sendRequest($sql, [$franchise]);

        return self::parseSqlDansArray($result);
    }

    public static function getProduitsByType(string $type): array
    {
        self::isConnected();

        $sql = 'SELECT * FROM v_Produits WHERE Type = ?';
        $result = self::$siteDB->sendRequest($sql, [$type]);

        return self::parseSqlDansArray($result);
    }

    public static function getProduitsSimilaire(Produit $produit): array
    {
        self::isConnected();

        $sql = 'SELECT * FROM v_Produits WHERE Franchise = ? AND IdProduit != ?';
        $result = self::$siteDB->sendRequest($sql, [$produit->getFranchise(), $produit->getId()]);

        return self::parseSqlDansArray($result);
    }

    public static function getProduitsEnPromotion(): array
    {
        self::isConnected();

        $sql = 'SELECT * FROM v_Produits WHERE Promotion != 0';
        $result = self::$siteDB->sendRequest($sql);

        return self::parseSqlDansArray($result);
    }

    public static function getFranchises(): array
    {
        self::isConnected();

        $sql = 'SELECT distinct Franchise FROM v_Produits';
        return array_column(self::$siteDB->sendRequest($sql), 'Franchise');
    }

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

    private static function isConnected()
    {
        if(!isset(self::$siteDB)) die('Non connecté à la base de donnée !');
    }
}
