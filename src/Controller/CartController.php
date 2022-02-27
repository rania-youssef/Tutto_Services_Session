<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(CartService $cartServ)
    {
      /*  $panier =$session->get('panier',[]);
         $panierData= [];
         $totale=0;

         foreach($panier as $id=>$quantity)
{
    $panierData[]=[
        'product'=>$product->find($id),
        'quantity'=>$quantity
    ];
    $totale+=($product->find($id)->getPrice())* $quantity;*/
    return $this->render('cart/index.html.twig', ['items'=>$cartServ->getFullCart(),'totale'=>$cartServ->getTotal()]);

}    



    

 /**
  * @Route("/panier/add{id}", name="cart_add")
  */
    public function add($id,CartService $cartSer )
   {
      /* $panier = $session->get('panier',[]);
       if (!empty($panier[$id])){
           $panier[$id]++;
       }else{
           $panier[$id] = 1;
       }

       $session->set('panier',$panier);*/
       $cartSer->add($id);

      return $this->redirectToRoute('product_index');

}

/**
 * @Route("/remove/panier/{id}", name="remove_panier")
 */
public function remove ($id,CartService $cartServ){

    $cartServ->remove($id);
    /*$panier=$session->get('panier',[]);

    if(!empty($panier[$id])){
        unset($panier[$id]);
    }

    $session->set('panier',$panier);*/

    return $this->redirectToRoute("cart_index");


}
}
    