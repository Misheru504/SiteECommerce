<?php

class DatabaseManager {
    private const HOST = '127.0.0.1';
    private const PORT = '3306';
    private const DBNAME = 'BriqueABrac';
    private const LOGIN = 'BAB_app';
    private const MDP = 'P@ssw0rd';
    private const CHARSET = 'utf8mb4';
    // private const CRYPT_KEY = '' ;

    private static ?PDO $cnx = null;

    /**
     * Créer une connexion avec la base de données
     *
     * @return void
     */
    private static function getConnection(): void
    {
        if(self::$cnx == null){
            $dsn = 'mysql:host='. self::HOST.';port='.self::PORT.';dbname='. self::DBNAME.';charset='.self::CHARSET;
            try {
                self::$cnx = new PDO($dsn, self::LOGIN, self::MDP);
                self::$cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }
    }

    /**
     * Execute une requête SQL dans la base de donnée et retourne son résultat
     *
     * @param string $request Requête SQL
     * @param array|null $stmtParams Paramètres de la requête
     * @param int|null $limit Limite de la requête (remplace le placeholder :limit dans la requête)
     * @param int|null $offset Offset de la requête (remplace le placeholder :offset dans la requête)
     * @return array<string, string> Tableau du résultat SQL
     */
    public static function sendRequest(string $request, ?array $stmtParams = null, ?int $limit = null, ?int $offset = null): array
    {
        if(!isset(self::$cnx)) { DatabaseManager::getConnection(); }

        $stmt = self::$cnx->prepare($request);
        if(isset($limit)) { $stmt->bindValue(':limit', $limit, PDO::PARAM_INT); }
        if(isset($offset)) { $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); }
        $stmt->execute($stmtParams);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }
}