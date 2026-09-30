<?php

class ProfilManager
{
    /**
     * Récupère un profil (combinaison d'un utilisateur et client) dans la base de données
     *
     * @param int $idUtilisateur Identifiant de l'utilisateur
     * @return Profil|null Profil de l'utilisateur
     */
    public static function getProfilFromUserId(int $idUtilisateur): ?Profil
    {
        $sql = "SELECT IdClient, NomClient, PrenomClient, MailClient, NumeroTelClient, Adresse, Ville, CodePostal, DateInscription FROM v_Users WHERE IdUtilisateur = ?";
        $result = DatabaseManager::sendRequest($sql, [$idUtilisateur]);

        if(!empty($result))
        {
            $user = $result[0];

            return new Profil(
                $user['IdClient'],
                $idUtilisateur,
                $user['NomClient'],
                $user['PrenomClient'],
                $user['MailClient'],
                $user['NumeroTelClient'],
                $user['Adresse'],
                $user['Ville'],
                $user['CodePostal'],
                $user['DateInscription']
            );
        }
        else
        {
            return null;
        }
    }
}
