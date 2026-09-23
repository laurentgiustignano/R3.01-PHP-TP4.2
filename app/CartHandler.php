<?php

namespace Iutrds\Tp42;

class CartHandler {
  private ?Cart $panier = null;

  public function __construct(
    private RequestParser $parser
  ) {}

  public function setPanier(Cart $panier) : void {
    $this->panier = $panier;
  }

  public function getCollection(Cart $panier) : array {
    return ['code' => 200, 'donnees' => ['products' => $panier->toListeApi()]];
  }

  public function ajouterProduit(Cart $panier, string $methode) : array {
    if ($methode !== 'POST') {
      return ['code' => 405, 'donnees' => ['error' => 'Méthode non autorisée. Utilisez GET ou POST']];
    }

    $entree = $this->parser->lireEntree();
    $erreur = $this->parser->validerAjout($entree ?? []);
    if ($erreur) {
      return ['code' => 400, 'donnees' => ['error' => $erreur]];
    }

    $panier->addItem($entree['product'], $entree['quantity']);
    return ['code' => 201, 'donnees' => ['message' => 'Produit ajouté', 'product' => $entree['product'], 'quantity' => $entree['quantity']]];
  }

  public function supprimerProduit(Cart $panier, string $produit, string $methode) : array {
    if ($methode !== 'DELETE') {
      return ['code' => 405, 'donnees' => ['error' => 'Méthode non autorisée. Utilisez DELETE']];
    }
    if (!isset($panier->getItems()[$produit])) {
      return ['code' => 404, 'donnees' => ['error' => "Produit '$produit' non trouvé dans le panier"]];
    }
    $panier->removeItem($produit);
    return ['code' => 200, 'donnees' => ['message' => "Produit '$produit' supprimé"]];
  }

  public function getSummary(Cart $panier, string $methode) : array {
    if ($methode !== 'GET') {
      return ['code' => 405, 'donnees' => ['error' => 'Méthode non autorisée. Utilisez GET']];
    }
    return ['code' => 200, 'donnees' => $panier->getSummary()];
  }

  public function setEntreeJson(?string $entree) : void {
    $this->parser->setEntreeJson($entree);
  }
}
