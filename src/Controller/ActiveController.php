<?php

namespace App\Controller;

use App\Repository\DealRepository;
use App\Repository\LocalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backoffice/active", name="active")
 */
class ActiveController extends AbstractController
{
    /**
     * @Route("/deal/{id}", name="deal")
     */
    public function activeDeal($id, DealRepository $dealRepository, SessionInterface $session)
    {
        $selectedDeal = $dealRepository->findOneBy(['id' => $id]);
        $session->set('deal', $selectedDeal);
        return $this->redirect('/admin');
    }


    /**
     * @Route("/local/{id}", name="local")
     */
    public function activeLocal($id, LocalRepository $localRepository, SessionInterface $session)
    {
        $selectedDeal = $localRepository->findOneBy(['id' => $id]);
        $session->set('local', $selectedDeal);
        return $this->redirect('/admin');
    }



}
