<?php

class Utilisateur
{
    private int $idUtilisateur;
    private int $email;
    private int $hashMotDePasse;


    public function __construct(int $idUtilisateur, int $email, int $hashMotDePasse)
    {
        $this->idUtilisateur = $idUtilisateur;
        $this->email = $email;
        $this->hashMotDePasse = $hashMotDePasse;
    }
}