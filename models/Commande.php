<?php

class Commande
{
    private int $id;
    private int $idClient;
    private ?string $dateCommande;
    private ?string $dateLivraison;
    /** @var array<int, int> $produitsQte Tableau des identifiants produits et de leur quantité dans la commande */
    private array $produitsQte;

    /** @var array<Produit> $produits Listes des objets Produit dans la commande */
    private array $produits;

    /**
     * Construit un nouvel objet Commande à partir des paramètres
     *
     * @param int $idCommande Identifiant de la commande
     * @param int $idClient Identifiant du client qui a passé la commande
     * @param string|null $dateCommande Date de la commande
     * @param string|null $dateLivraison Date de livraison
     * @param array<int, int> $produitsQte Tableau associatif des identifiants des produits à leur quantité ( idProduit -> qte)
     * @param array<Produit> $produits Liste des produits commandés
     */
    public function __construct(int $idCommande, int $idClient, ?string $dateCommande, ?string $dateLivraison, array $produitsQte, array $produits)
    {
        $this->id = $idCommande;
        $this->idClient = $idClient;
        $this->dateCommande = $dateCommande;
        $this->dateLivraison = $dateLivraison;
        $this->produitsQte = $produitsQte;
        $this->produits = $produits;
    }

    /**
     * @return bool Retourne si la commande à été livrée (date de livraison différent de null)
     */
    public function estLivree(): bool
    {
        return isset($this->dateLivraison);
    }

    public function getProduits(): array { return $this->produits; }

    public function getProduitsQte(): array { return $this->produitsQte; }

    public function getId(): int { return $this->id; }
    public function getIdClient(): int { return $this->idClient; }
    public function getDateCommande(): ?string { return $this->dateCommande; }
    public function getDateLivraison(): ?string { return $this->dateLivraison; }
    public function getPrixTotal(): float
    {
        $prix = 0;
        foreach ($this->produits as $produit)
        {
            $prix += $produit->getPrix() * $this->produitsQte[$produit->getId()];
        }
        return $prix;
    }
}
