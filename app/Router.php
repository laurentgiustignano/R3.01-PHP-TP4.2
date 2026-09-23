<?php

namespace Iutrds\Tp42;

class Router {

  private CartHandler $handler;
  private ?Cart $panierPartage = null;

  public function __construct(?Cart $panier = null, ?CartHandler $handler = null) {
    $this->panierPartage = $panier;
    $this->handler = $handler ?? new CartHandler(
      new RequestParser()
    );
  }

  public function setEntreeJson(?string $entree) : void {
    $this->handler->setEntreeJson($entree);
  }

  public function traiter(string $methode, string $uri) : array {
    $url = parse_url($uri, PHP_URL_PATH);

    if ($url === '/api/cart' || $url === '/api/cart/') {
      return $this->traiterCollection($methode);
    }
    elseif ($url === '/api/cart/summary') {
      return $this->traiterSummary($methode);
    }
    elseif (preg_match('#^/api/cart/([^/]+)$#', $url, $matches)) {
      return $this->traiterProduit($methode, $matches[1]);
    }
    else {
      return ['code' => 404, 'donnees' => ['error' => 'Route non trouvée. Endpoints disponibles: GET/POST /api/cart, DELETE /api/cart/{product}, GET /api/cart/summary']];
    }
  }

  private function traiterCollection(string $methode) : array {
    $panier = $this->panierPartage ?? new Cart();
    $this->handler->setPanier($panier);

    if ($methode === 'GET') {
      return $this->handler->getCollection($panier);
    }
    else {
      return $this->handler->ajouterProduit($panier, $methode);
    }
  }

  private function traiterProduit(string $methode, string $produit) : array {
    $panier = $this->panierPartage ?? new Cart();
    $this->handler->setPanier($panier);
    return $this->handler->supprimerProduit($panier, $produit, $methode);
  }

  private function traiterSummary(string $methode) : array {
    $panier = $this->panierPartage ?? new Cart();
    $this->handler->setPanier($panier);
    return $this->handler->getSummary($panier, $methode);
  }
}
