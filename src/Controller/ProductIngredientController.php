<?php

namespace App\Controller;

use App\Entity\ProductIngredient;
use App\Form\ProductIngredient1Type;
use App\Form\ProductIngredientType;
use App\Repository\ProductIngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backoffice/contenido")
 */
class ProductIngredientController extends AbstractController
{
    /**
     * @Route("/", name="product_ingredient_index", methods={"GET"})
     */
    public function index(ProductIngredientRepository $productIngredientRepository): Response
    {

        return $this->render('product_ingredient/index.html.twig', [
            'product_ingredients' => $productIngredientRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_ingredient_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $productIngredient = new ProductIngredient();
        $form = $this->createForm(ProductIngredientType::class, $productIngredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($productIngredient);
            $entityManager->flush();

            return $this->redirectToRoute('product_ingredient_index');
        }

        return $this->render('product_ingredient/new.html.twig', [
            'product_ingredient' => $productIngredient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_ingredient_show", methods={"GET"})
     */
    public function show(ProductIngredient $productIngredient): Response
    {
        return $this->render('product_ingredient/show.html.twig', [
            'product_ingredient' => $productIngredient,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_ingredient_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProductIngredient $productIngredient): Response
    {
        $form = $this->createForm(ProductIngredientType::class, $productIngredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_ingredient_index', [
                'id' => $productIngredient->getId(),
            ]);
        }

        return $this->render('product_ingredient/edit.html.twig', [
            'product_ingredient' => $productIngredient,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_ingredient_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProductIngredient $productIngredient): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productIngredient->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($productIngredient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_ingredient_index');
    }
}
