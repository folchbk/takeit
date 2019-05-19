<?php

namespace App\Controller;

use App\Entity\CategoryProduct;
use App\Entity\Local;
use App\Form\CategoryProductType;
use App\Repository\CategoryProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backoffice/category/product")
 */
class CategoryProductController extends AbstractController
{
    /**
     * @Route("/", name="category_product_index", methods={"GET"})
     */
    public function index(CategoryProductRepository $categoryProductRepository): Response
    {
        return $this->render('category_product/index.html.twig', [
            'category_products' => $categoryProductRepository->findByFamilyNull(),
        ]);
    }

    /**
     * @Route("/new", name="category_product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categoryProduct = new CategoryProduct();
        $form = $this->createForm(CategoryProductType::class, $categoryProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $session = $request->getSession();
            $localRepository = $entityManager->getRepository(Local::class);
            /*
             * Recupero el local de sesion
             * y se lo asigno a producto
             */
            $local_in_session = $session->get('local');
            $local = $localRepository->find($local_in_session->getId());
            $categoryProduct->setLocal($local);

            foreach ($categoryProduct->getSubCategories() as $subCategory) {
                $subCategory->setCategoryProduct($categoryProduct);
                $subCategory->setLocal($local);
            }

            $entityManager->persist($categoryProduct);
            $entityManager->flush();

            return $this->redirectToRoute('category_product_index');
        }

        return $this->render('category_product/new.html.twig', [
            'category_product' => $categoryProduct,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_product_show", methods={"GET"})
     */
    public function show(CategoryProduct $categoryProduct): Response
    {
        return $this->render('category_product/show.html.twig', [
            'category_product' => $categoryProduct,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="category_product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategoryProduct $categoryProduct): Response
    {
        $form = $this->createForm(CategoryProductType::class, $categoryProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $session = $request->getSession();
            $localRepository = $entityManager->getRepository(Local::class);

            /*
             * Recupero el local de sesion
             * y se lo asigno a producto
             */
            $local_in_session = $session->get('local');
            $local = $localRepository->find($local_in_session->getId());
            $categoryProduct->setLocal($local);

            foreach ($categoryProduct->getSubCategories() as $subCategory) {
                $subCategory->setCategoryProduct($categoryProduct);
                $subCategory->setLocal($local);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_product_index', [
                'id' => $categoryProduct->getId(),
            ]);
        }

        return $this->render('category_product/edit.html.twig', [
            'category_product' => $categoryProduct,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CategoryProduct $categoryProduct): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoryProduct->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categoryProduct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_product_index');
    }
}
