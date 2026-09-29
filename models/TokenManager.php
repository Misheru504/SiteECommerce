<?php

class TokenManager
{
    /**
     * Crée un token et insert son hash dans la base de données
     *
     * @param int $userId Identifiant de l'utilisateur
     * @return string Token non hashé
     * @throws \Random\RandomException Aucune source d'aléatoire n'a pu être trouvé
     */
    public static function createToken(int $userId): string
    {
        $token = bin2hex(random_bytes(32));
        $tokenHash = hash('sha256', $token);

        $expiration = (new DateTime("+30 days"))->format('Y-m-d H:i:s');
        $nomAppareil = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown device';
        $sql = "INSERT INTO Token(tokenHash, dateExpiration, nomAppareil, idUtilisateur) VALUES (?, ?, ?, ?)";
        DatabaseManager::sendRequest($sql, [$tokenHash, $expiration, $nomAppareil, $userId]);

        return $token;
    }
}
