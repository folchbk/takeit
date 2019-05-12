<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        return $this->redirect("/admin");
//        return $this->render('default/indexCart.html.twig', [
//            'controller_name' => 'DefaultController',
//        ]);
    }
}
