<?php

class AuthentificationController
{
    public static function showLoginPage()
    {
        $pageTitle = 'Connexion';
        $currentPage = 'login';

        if(!empty($_POST)){
            try {
                if(empty($_POST['password']) || empty($_POST['email'])) {
                    throw new Exception('Le formulaire est incomplet !');
                }

                require_once 'class/DBUser.class.php';

                $email = $_POST['email'];
                $password = $_POST['password'];

                $db = new DBUser('client', 'P@ssw0rd2');
                $sql = 'SELECT motDePasse FROM Utilisateur WHERE email = ?';
                $db->getBddConnexion();
                $result = $db->sendRequest($sql, [$email]);

                if(empty($result) || !password_verify($password, $result[0]['motDePasse'])) {
                    throw new Exception('Adresse mail ou mot de passe incorrect!');
                }

                print 'Connexion réussie !';
            }
            catch(Exception $e) {
                $errorMessage = 'Erreur : '.$e->getMessage();
            }
        }

        require ROOT_PATH . '/views/LoginView.php';
    }

    public static function attemptLogin()
    {

    }
}