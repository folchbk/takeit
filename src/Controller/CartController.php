<?php

namespace App\Controller;

use App\Entity\CategoryProduct;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Deal;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;


class CartController extends AbstractController
{

    /**
     * @Route("/cart", name="cart")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(CategoryProduct::class)->findAll();
        $products = $em->getRepository(Product::class)->findAll();
        $product = $em->getRepository(Product::class)->findOneBy(array('id'=>22));

        return $this->render('cart/indexCart.html.twig', array(
            'categories' => $categories,
            'products' => $products
        ));
    }

}
