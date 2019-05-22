<?php

namespace App\Controller;

use App\Entity\Deal;
use App\Entity\Local;
use App\Repository\LocalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/backoffice", name="backoffice")
     */
    public function index(SessionInterface $session)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $localRepository = $entityManager->getRepository(Local::class);
        $dealRepository = $entityManager->getRepository(Deal::class);

        $session->set('user', $this->getUser());
        $selectedDeal = $session->get('deal');
        $selectedLocal = $session->get('local');

        $user = $this->getUser();
        $deals = [];
        foreach ($user->getLocals() as $local) {
            $deals[] = $local->getDeal();
        }

        foreach ($user->getDeals() as $deal) {
            $deals[] = $deal;
        }
        $deals = array_unique($deals);

        $locals = ($selectedDeal != null) ? $localRepository->findByDeal($selectedDeal) : null;

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
