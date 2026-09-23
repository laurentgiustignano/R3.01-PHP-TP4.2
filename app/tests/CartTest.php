<?php

namespace Iutrds\Tp42\tests;

use Iutrds\Tp42\Cart;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase {


  public function testAjoutDUnSeulProduit() : void {
    $panier = new Cart();

    $panier->addItem("truc", 1);
    $this->assertEquals(1, $panier->getTotalProducts());
    $this->assertEquals(1, $panier->getTotalItems());
  }

  public function testAjoutPlusieursProduits() : void{
    $panier = new Cart();

    $panier->addItem("truc", 1);
    $this->assertEquals(1, $panier->getTotalProducts());

    $panier->addItem("truc", 1);
    $panier->addItem("truc", 1);
    $this->assertEquals(3, $panier->getTotalItems());
  }

}
