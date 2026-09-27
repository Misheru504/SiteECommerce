<?php

class DatabaseManager {
    private const HOST = '127.0.0.1';
    private const PORT = '3306';
    private const DBNAME = 'BriqueABrac';
    private const LOGIN = 'BAB_app';
    private const MDP = 'P@ssw0rd';
    private const CHARSET = 'utf8mb4';
    // private const CRYPT_KEY = '';

    private static ?\PDO $cnx = null;

    /**
     * Créer une connexion avec la base de données
     *
     * @return PDO
     */
    public static function getConnection(): PDO{
        if(self::$cnx == null){
            $dsn = 'mysql:host='. self::HOST.';port='.self::PORT.';dbname='. self::DBNAME.';charset='.self::CHARSET;
            try {
                self::$cnx = new PDO($dsn, self::LOGIN, self::MDP);
                self::$cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }
        return self::$cnx;
    }

}