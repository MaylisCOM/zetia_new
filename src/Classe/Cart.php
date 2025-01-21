<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart {

    private float $totalPrice =0.0;
   

    public function __construct(private RequestStack $requestStack) {
    
    }
    public function add($illustration) {
      
        $cart = $this->requestStack->getSession()->get('cart', []);
       
        $id = $illustration->getId();


        if (empty($cart[$id])) {
           $cart[$illustration->getId()]=[
            'object'=>$illustration,
            'qty'=>1
           ];
        }else {
            $cart[$id]['qty']++;
        } 

        $this->requestStack->getSession()->set('cart', $cart);
        // ajoute le prix de l'illustration au prix total
        $this->totalPrice += $illustration->getPrice() * $cart[$id]['qty'];
       
    }

    public function getCart() {
       return $this->requestStack->getSession()->get('cart', []);
       
    }

    public function getTotalPrice(): float {
        $cart = $this->getCart();
        $totalPrice = 0.0;

        foreach ($cart as $item) {
            $totalPrice += $item['object']->getPrice() * $item['qty'];
        }

        return $totalPrice;
    }

    public function getTotalQuantity(): int {
        $cart = $this->getCart();
        $totalQuantity = 0;

        foreach ($cart as $item) {
            $totalQuantity +=  $item['qty'];
        }

        return $totalQuantity;
    }
    
    public function substractPrice($price) {
        $this->totalPrice -= $price;
    }

    public function remove($illustration) {
        $cart = $this->requestStack->getSession()->get('cart', []);
        $id = $illustration->getId();
        if (!empty($cart[$id])) {
            $this->substractPrice($cart[$id]['object']->getPrice());
            unset($cart[$id]);
        }
        $this->requestStack->getSession()->set('cart', $cart);
    }

    public function reset() {
        $this->requestStack->getSession()->set('cart', []);
        $this->totalPrice = 0.0;
    }

    
}