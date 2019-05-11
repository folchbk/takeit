<?php

namespace App\Controller;

use App\Repository\LocalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/backoffice", name="backoffice")
     */
    public function index(LocalRepository $localRepository, SessionInterface $session)
    {
        $selectedDeal = $session->get('deal');
        $selectedLocal = $session->get('local');
        $locals = ($selectedDeal != null) ? $localRepository->findByDeal($selectedDeal->getId()) : null;

        if ($selectedDeal != null && $selectedLocal != null) {
            return $this->render('home/index.html.twig', [
                'deal' => $selectedDeal,
                'local' => $selectedLocal,
            ]);
        }

        $user = $this->getUser();
        $deals = $user->getDeals();

        return $this->render('home/select.html.twig', [
            'deals' => $deals,
            'locals' => $locals,
            'deal' => $selectedDeal,
            'local' => $selectedLocal
        ]);
    }
}
