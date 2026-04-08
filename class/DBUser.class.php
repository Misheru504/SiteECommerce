<?php
const HOST = '127.0.0.1';
const PORT = '3306';
const DBNAME = 'BriqueABrac';
const CHARSET = 'utf8mb4';
class DBUser
{
    private string $user;
    private string $password;

    private ?PDO $cnx;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
        $this->cnx = null;
    }

    function getBddConnexion()
    {
        $dsn = 'mysql:host='.HOST.';port='.PORT.';dbname='.DBNAME.';charset='.CHARSET;

        try {
            $cnx = new PDO($dsn, $this->user, $this->password);
            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->cnx = $cnx;
        }
        catch (PDOException $e) {
            print_r($e->getMessage());
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }

    function sendRequest($request, $stmtParams = null): array
    {
        if(!isset($this->cnx)) { die('Non connecté à la base de donnée. '); }

        $stmt = $this->cnx->prepare($request);
        $stmt->execute($stmtParams);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }
}