<?php
class Produit
{
    private $id;
    private $nom;
    private $description;
    private $nbPieces;
    private $prix;
    private $oldPrice;
    private $promo;
    private $age;
    private $franchise;
    private $type;

    public function __construct($produitBdd)
    {
        $this->id = $produitBdd['IdProduit'];
        $this->nom = htmlspecialchars($produitBdd['NomProduit']);
        $this->description = htmlspecialchars($produitBdd['Description']);
        $this->nbPieces = $produitBdd['NbPieces'];
        $this->prix = number_format($produitBdd['Prix'], 2, ',', ' ');
        $this->promo = $produitBdd['Promotion'];
        $this->oldPrice = null;

        if($this->promo != 0)
        {
            $this->oldPrice = number_format($produitBdd['Prix'], 2, ',', ' ');
            $tmpPrix = $produitBdd['Prix'] * (1 - $this->promo / 100);
            $this->prix = number_format($tmpPrix, 2, ',', ' ');
        }

        $this->age = htmlspecialchars($produitBdd['Age']);
        $this->franchise = htmlspecialchars($produitBdd['Franchise']);
        $this->type = htmlspecialchars($produitBdd['Type']);
    }

    public function getId(): int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function getDescription(): string { return $this->description; }
    public function getNbPieces(): int { return $this->nbPieces; }
    public function getOldPrice(): string { return $this->oldPrice; }
    public function getPrix(): string { return $this->prix; }
    public function getPromo(): float { return $this->promo; }
    public function getAge(): string { return $this->age; }
    public function getFranchise(): string { return $this->franchise; }
    public function getType(): string { return $this->type; }
}