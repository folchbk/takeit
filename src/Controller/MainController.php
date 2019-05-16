<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Deal;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;


class MainController extends AbstractController
{

    /**
     * @Route("/main", name="main")
     */
    public function index()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        return $this->render('main/index.html.twig', array(
            'deals' => $user->getDeals(),
        ));
    }

    /**
     * @Route("/getLocals", name="getLocals")
     */
    public function getLocals()
    {

        $em = $this->getDoctrine()->getManager();
        $deal = $em->getRepository(Deal::class)->findOneBy(array('id' => $_POST['deal']));

        $this->get('session')->set('deal',$deal);

        $localsFromDeal = $deal->getLocals();
        $locales = array();
        foreach ($localsFromDeal as $local) {
            $locales[$local->getId()] = $local->getName();
        }
        return new JsonResponse($locales);
    }
}
