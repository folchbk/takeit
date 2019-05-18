<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Deal;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;


class KitchenController extends AbstractController
{

    /**
     * @Route("/kitchen", name="kitchen")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager()->getRepository(Order::class);
        $orders = $em->findBy(array('status' => 'pending'));

        return $this->render('kitchen/indexKitchen.html.twig', array(
            'orders' => $orders,
        ));
    }

}
