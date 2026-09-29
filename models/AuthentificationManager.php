<?php

class AuthentificationManager
{
    /**
     * Effectue une tentative de connexion du site dans la BDD
     *
     * @param string $login Login de l'utilisateur (email)
     * @param string $password Mot de passe non hashé de l'utilisateur
     * @return bool|int Faux si la tentative de connexion n'a pas abouti | Identifiant de l'utilisateur si la connexion a réussi
     */
    public static function attemptLogin(string $login, string $password): bool|int
    {
        $result = DatabaseManager::sendRequest('SELECT motDePasse, idUtilisateur FROM Utilisateur WHERE email = ?', [$login]);

        if(empty($result) || !password_verify($password, $result[0]['motDePasse'])) {
            return false;
        }

        return (int) $result[0]['idUtilisateur'];
    }
}
