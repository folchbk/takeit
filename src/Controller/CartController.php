<?php

namespace App\Controller;

use App\Entity\CategoryProduct;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Deal;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;


class CartController extends AbstractController
{

    /**
     * @Route("/cart", name="cart")
     */
    public function index(Request $request)
    {
        $table = $request->cookies->get('table');
        if (!$table) {
            return $this->redirect('/');
        }
            $em = $this->getDoctrine()->getManager();
            $categories = ($request->cookies->get('local') == null)
                ? $em->getRepository(CategoryProduct::class)->findAll() :$em->getRepository(CategoryProduct::class)->findBy(['local' => $request->cookies->get('local')]);
            $productRepository = $em->getRepository(Product::class);
            $products = ($request->cookies->get('local') == null)
                ? $productRepository->findAll() : $productRepository->findBy(['local' => $request->cookies->get('local')]);
            return $this->render('cart/indexCart.html.twig', array(
                'categories' => $categories,
                'products' => $products
            ));
    }

}
