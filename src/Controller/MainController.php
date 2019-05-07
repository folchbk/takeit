<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Deal;
use Symfony\Component\HttpFoundation\JsonResponse;


class MainController extends AbstractController
{

    /**
     * @Route("/main", name="main")
     */
    public function index()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        var_dump($user->getId());
        $em = $this->getDoctrine()->getManager();
        $deals = $em->getRepository(Deal::class)
            ->findAllq();
        return $this->render('main/index.html.twig', array(
            'deals' => $deals,
        ));
    }

    /**
     * @Route("/getLocals", name="getLocals")
     */
    public function getLocals()
    {
        $em = $this->getDoctrine()->getManager();
        $deal = $em->getRepository(Deal::class)->findOneBy(array('id' => $_POST['deal']));
        $localsFromDeal = $deal->getLocals();

        $locales = array();
        foreach ($localsFromDeal as $local) {
            $locales[$local->getId()] = $local->getName();
        }
        return new JsonResponse($locales);
    }
}
