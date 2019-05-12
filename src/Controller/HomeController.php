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
        $session->set('user', $this->getUser());
        $selectedDeal = $session->get('deal');
        $selectedLocal = $session->get('local');
        $user = $this->getUser();
        $deals = $user->getDeals();
        $locals = ($selectedDeal != null) ? $localRepository->findByDeal($selectedDeal->getId()) : null;

        if ($selectedDeal != null && $selectedLocal != null) {
            return $this->render('home/index.html.twig', [
                'deal' => $selectedDeal,
                'local' => $selectedLocal
            ]);
        }

        return $this->render('home/select.html.twig', [
            'deals' => $deals,
            'locals' => $locals,
            'deal' => $selectedDeal,
            'local' => $selectedLocal
        ]);
    }
}
