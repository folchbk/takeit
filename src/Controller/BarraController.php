<?php

namespace App\Controller;

use App\Entity\CategoryProduct;
use App\Entity\HelpRequest;
use App\Entity\Order;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BarraController extends AbstractController
{
    /**
     * @Route("/barra", name="barra")
     */
    public function index(Request $request)
    {
        $table = $request->cookies->get('table');
        if (!$table) {
            return $this->redirect('/');
        } else {
            $em = $this->getDoctrine()->getManager();
            $categories = $em->getRepository(CategoryProduct::class)->findAll();
            $products = $em->getRepository(Product::class)->findAll();

            $helpRequest = $em->getRepository(HelpRequest::class)->findBy(array('status' => 'pending'));
            $orders = $em->getRepository(Order::class)->findBy(array('status' => 'pending-pay'));

            return $this->render('barra/indexBarra.html.twig', array(
                'categories' => $categories,
                'products' => $products,
                'orders' => $orders,
                'helpRequest' => $helpRequest,
            ));
        }
    }
}
