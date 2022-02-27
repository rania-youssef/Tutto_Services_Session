<?php

namespace App\Controller;

use Faker\Factory;
use App\Entity\Product;
use Liior\Faker\Prices;

use App\Form\ProductType;
use Doctrine\ORM\EntityManager;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
       
        /**
         * @Route("/", name="product_index")
         */
        public function index(ProductRepository $productRepository)
        
        { 
        
            return $this->render('product/index.html.twig', [
                'products' => $productRepository->findAll()
            ]);

        }


        /**
         * @Route("/affiche")
         */

         public function aff(){
            $form=$this->createForm(ProductType::class);
             return $this->render("product/new1.html.twig",['form'=>$form->createView()]);
         }
        /**
         * @Route("/new_prod",name="new_prod")
         */
        public function newProduct(Request $request,EntityManagerInterface $em, ProductRepository $productRepository)
        {
            
            $product =new Product();
            $form = $this->createForm(ProductType::class,$product);
            $form->handleRequest($request);
            if($form->isSubmitted()) {
                $image=$form["image"]->getData();

            

            if($image){
                
                
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
            // On copie le fichier dans le dossier uploads
              dd($fichier);
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                //dd($fichier);
              $product->setImage($fichier);

           }

           $em->persist($product);
          $em->flush();
          return $this->redirectToRoute("product_index");
          
        }
       return $this->render("product/new.html.twig",["form"=>$form->createView()]);
    }
    
        
        

         
    

    
    
    
}

