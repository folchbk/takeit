<?php

namespace App\Controller;

use App\Entity\CategoryProduct;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BarraController extends AbstractController
{
    /**
     * @Route("/barra", name="barra")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(CategoryProduct::class)->findAll();
        $products = $em->getRepository(Product::class)->findAll();

        return $this->render('barra/indexBarra.html.twig', array(
            'categories' => $categories,
            'products' => $products
        ));
    }
}
