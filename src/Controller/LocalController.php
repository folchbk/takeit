<?php

namespace App\Controller;

use App\Entity\Local;
use App\Form\LocalType;
use App\Repository\LocalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backoffice/local")
 */
class LocalController extends AbstractController
{
    /**
     * @Route("/", name="local_index", methods={"GET"})
     */
    public function index(LocalRepository $localRepository): Response
    {
        return $this->render('local/index.html.twig', [
            'locals' => $localRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="local_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $local = new Local();
        $form = $this->createForm(LocalType::class, $local);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($local);
            $entityManager->flush();

            return $this->redirectToRoute('local_index');
        }

        return $this->render('local/new.html.twig', [
            'local' => $local,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="local_show", methods={"GET"})
     */
    public function show(Local $local): Response
    {
        return $this->render('local/show.html.twig', [
            'local' => $local,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="local_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Local $local): Response
    {
        $form = $this->createForm(LocalType::class, $local);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('local_index', [
                'id' => $local->getId(),
            ]);
        }

        return $this->render('local/edit.html.twig', [
            'local' => $local,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="local_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Local $local): Response
    {
        if ($this->isCsrfTokenValid('delete'.$local->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($local);
            $entityManager->flush();
        }

        return $this->redirectToRoute('local_index');
    }
}
