<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductIngredient;
use App\Form\ProductType;
use App\Repository\IngredientRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backoffice/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request, SessionInterface $session, IngredientRepository $ingredientRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $product->setLocal($session->get('local'));

//            $ingredients = $request->get('product')['productIngredients'];
//            foreach ($ingredients as $ingredient) {
//                $quantity = $ingredient['quantity'];
//                $ingredient = $ingredientRepository->find(['id' => $ingredient['ingredient']]);
//
//                $productIngredient = new ProductIngredient();
//                $productIngredient->setIngredient($ingredient);
//                $productIngredient->setProduct($product);
//                $productIngredient->setQuantity($quantity);
//
//                $product->addProductIngredient($productIngredient);
//                $ingredient->addProductIngredient($productIngredient);
//
//                $entityManager->persist($product);
//                $entityManager->persist($ingredient);
//                $entityManager->persist($productIngredient);
//
//                var_dump($productIngredient->getId());
//                var_dump($product->getId());
//                var_dump($product->getId());
//                die();
//                $entityManager->flush();
//            }


            $ingredient = $ingredientRepository->find(['id' => 1]);
            $productIngredient = new ProductIngredient();

//            $product->addProductIngredient($productIngredient);
//            $ingredient->addProductIngredient($productIngredient);


//            var_dump($productIngredient->getId());
//            var_dump($product->getId());
//            var_dump($ingredient->getId());
//
//            echo "-----------" . PHP_EOL;

            $entityManager->merge($productIngredient);
            $entityManager->merge($product);
            $entityManager->persist($ingredient);
//            $entityManager->flush();


//            $productIngredient->setIngredient($ingredient);
//            $productIngredient->setProduct($product);
//            $productIngredient->setQuantity(4);

//            echo "ID:";
//            var_dump($productIngredient->getId());
//            echo "Product:";
//            var_dump($productIngredient->getProduct()->getId());
//            echo "Ingredient:";
//            var_dump($productIngredient->getIngredient()->getId());

            $product->addProductIngredient($productIngredient);
            $ingredient->addProductIngredient($productIngredient);

            $productIngredient->setQuantity(4);
            $entityManager->merge($productIngredient);
            $entityManager->flush();


//            var_dump($productIngredient->getId());
//            var_dump($product->getId());
//            var_dump($ingredient->getId());


//            $product->addProductIngredient($productIngredient);
//            $ingredient->addProductIngredient($productIngredient);

//            $productIngredient->setIngredient($ingredient);
//            $productIngredient->setProduct($product);

            //                $productIngredient->setProduct($product);
//                $productIngredient->setQuantity($quantity);

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'ingredients' => $ingredientRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index', [
                'id' => $product->getId(),
            ]);
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index');
    }
}
