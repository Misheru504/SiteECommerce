<?php

class Profil
{
    private int $idClient;
    private int $idUtilisateur;
    private string $nomClient;
    private string $prenomClient;
    private string $mailClient;
    private string $numeroTelClient;
    private string $adresse;
    private string $ville;
    private string $codePostal;
    private string $dateinscription;

    public function __construct(int $idClient, int $idUtilisateur, string $nomClient, string $prenomClient, string $mailClient, string $numeroTelClient, string $adresse, string $ville, string $codePostal, string $dateinscription)
    {
        $this->idClient = $idClient;
        $this->idUtilisateur = $idUtilisateur;
        $this->nomClient = $nomClient;
        $this->prenomClient = $prenomClient;
        $this->mailClient = $mailClient;
        $this->numeroTelClient = $numeroTelClient;
        $this->adresse = $adresse;
        $this->ville = $ville;
        $this->codePostal = $codePostal;
        $this->dateinscription = $dateinscription;
    }

    public function getIdClient(): int { return $this->idClient; }
    public function getIdUtilisateur(): int { return $this->idUtilisateur; }
    public function getNomClient(): string { return $this->nomClient; }
    public function getPrenomClient(): string { return $this->prenomClient; }
    public function getMailClient(): string { return $this->mailClient; }
    public function getNumeroTelClient(): string { return $this->numeroTelClient; }
    public function getAdresse(): string { return $this->adresse; }
    public function getVille(): string { return $this->ville; }
    public function getCodePostal(): string { return $this->codePostal; }
    public function getDateinscription(): string { return $this->dateinscription; }
}
