<?php
class Commande
{
    private int $idCommande;
    private string $dateCommande;
    private ?string $dateLivraison;

    private array $produits;

    public function __construct(Array $commande)
    {
        $this->idCommande = $commande['idCommande'];
        $this->dateCommande = $commande['dateCommande'];
        $this->dateLivraison = $commande['dateLivraison'];
    }

    public function getIdCommande(): int
    {
        return $this->idCommande;
    }

    public function getDateCommande(): string
    {
        return $this->dateCommande;
    }

    public function getDateLivraison(): ?string
    {
        return $this->dateLivraison;
    }

    public function getProduits(): array
    {
        return $this->produits;
    }

    public function setProduits(array $produits)
    {
        foreach ($produits as $produit)
        {
            $produitObj = new Produit($produit);
            $this->addProduit($produitObj, $produits['qte']);
        }
    }

    public function addProduit(Produit $produit, int $qte)
    {
        $p['produit'] = $produit;
        $p['qte'] = $qte;
        $this->produits[] = $p;
    }

    public function estLivrée(): bool
    {
        return isset($this->dateLivraison);
    }
}