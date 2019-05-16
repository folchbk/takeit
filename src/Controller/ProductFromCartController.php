<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductIngredient;
use App\Form\ProductType;
use App\Repository\IngredientRepository;
use App\Repository\LocalRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;



class ProductFromCartController extends AbstractController
{
    private $serializer;
    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }



    /**
     * @Route("/getProduct/{id}", name="getProduct")
     */
    public function getProduct($id)
    {
        $em = $this->getDoctrine()->getManager()->getRepository(Product::class);
        $product = $em->findOneBy(array('id'=>$id));

        $filteredProduct = array(
            'id' => $product->getId(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice()
        );

        $response = new Response(json_encode($filteredProduct));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
