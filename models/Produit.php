<?php
class Produit
{
    private int $id;
    private string $codeSet;
    private string $nom;
    private string $description;
    private int $nbPieces;
    private float $prix;
    private ?float $oldPrice;
    private float $promo;
    private string $age;
    private string $franchise;
    private string $type;

    public function __construct(int $id, string $codeSet, string $nom, string $description, int $nbPieces, float $prix, float $promo, string $age, string $franchise, string $type)
    {
        $this->id = $id;
        $this->codeSet = $codeSet;
        $this->nom = htmlspecialchars($nom);
        $this->description = htmlspecialchars($description);
        $this->nbPieces = $nbPieces;
        $this->prix = $prix;
        $this->promo = $promo;
        $this->oldPrice = null;

        if($this->promo != 0)
        {
            $this->oldPrice = $this->prix;
            $this->prix = $prix * (1 - $this->promo / 100);
        }

        $this->age = htmlspecialchars($age);
        $this->franchise = htmlspecialchars($franchise);
        $this->type = htmlspecialchars($type);
    }

    public function getId(): int { return $this->id; }
    public function getCodeSet(): string { return $this->codeSet; }
    public function getNom(): string { return $this->nom; }
    public function getDescription(): string { return $this->description; }
    public function getNbPieces(): int { return $this->nbPieces; }
    public function getOldPrice(): string { return $this->oldPrice; }
    public function getPrix(): float { return $this->prix; }
    public function getPromo(): float { return $this->promo; }
    public function getAge(): string { return $this->age; }
    public function getFranchise(): string { return $this->franchise; }
    public function getType(): string { return $this->type; }

    /**
     * Construit un objet Produit à partir d'un tableau des champs de la vue SQL
     *
     * @param array<string, mixed> $sqlArray Tableau SQL avec les champs de la vue
     * @return Produit Nouveau produit
     */
    public static function constructProduitFromSqlArray(array $sqlArray): Produit
    {
        return new Produit(
            $sqlArray['IdProduit'],
            $sqlArray['CodeSet'],
            $sqlArray['NomProduit'],
            $sqlArray['Description'],
            $sqlArray['NbPieces'],
            $sqlArray['Prix'],
            $sqlArray['Promotion'],
            $sqlArray['Age'],
            $sqlArray['Franchise'],
            $sqlArray['Type']
        );
    }

    /**
     * Change le format d'un prix
     *
     * @param float $prix Prix du produit
     * @return string Prix formatté
     */
    public static function formatPrice(float $prix): string
    {
        return number_format($prix, 2, ',', ' ');
    }
}