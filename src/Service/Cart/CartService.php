<?php

namespace App\Service\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService {
    
    protected $session;
    protected $productRep;

    public function __construct (SessionInterface $session,ProductRepository $productRep){
 $this->session=$session;
 $this->productRep=$productRep;
    }
    

 public function add(int $id)
 {
    $panier = $this->session->get('panier',[]);
    if (!empty($panier[$id])){
        $panier[$id]++;
    }else{
        $panier[$id] = 1;
    }

    $this->session->set('panier',$panier);
 }

 public function remove(int $id)
 {
    $panier=$this->session->get('panier',[]);

    if(!empty($panier[$id])){
        unset($panier[$id]);
    }

    $this->session->set('panier',$panier);
 }

 public function getFullCart ():array
 {
    $panier =$this->session->get('panier',[]);
    $panierData= [];
    $totale=0;

    foreach($panier as $id=>$quantity)
{
$panierData[]=[
   'product'=>$this->productRep->find($id),
   'quantity'=>$quantity
];

}    
return($panierData);
}
 
 public function getTotal():float
 {
    $cart=$this->getFullCart();
    $totale=0;
    foreach($cart as $c){
        $totale+=$c['product']->getPrice()*$c['quantity'];
    }
    return($totale);
}


}