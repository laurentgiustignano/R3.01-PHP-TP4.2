<?php

namespace Iutrds\Tp42;

class RequestParser {
  private ?string $entreeJson = null;

  public function setEntreeJson(?string $entree) : void {
    $this->entreeJson = $entree;
  }

  public function lireEntree() : ?array {
    if ($this->entreeJson !== null) {
      $resultat = json_decode($this->entreeJson, true);
      $this->entreeJson = null;
      return $resultat;
    }
    $entree = file_get_contents('php://input');
    if (empty($entree)) {
      return null;
    }
    return json_decode($entree, true);
  }

  public function validerAjout(array $entree) : ?string {
    if (!$entree || !isset($entree['product'], $entree['quantity'])) {
      return 'Corps requis: {"product": "nom", "quantity": nombre}';
    }
    if (!is_string($entree['product']) || !is_int($entree['quantity']) || $entree['quantity'] < 1) {
      return 'product doit être une chaîne et quantity un entier positif';
    }
    return null;
  }
}
