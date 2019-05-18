<?php

namespace App\Controller;

use App\Entity\Deal;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Product;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class OrderController extends AbstractController
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
     * @Route("/getActiveOrders", name="order")
     */
    public function getActiveOrders()
    {
        $date = new \DateTime("now");
        $timestamp = $date->getTimestamp();
        $recentOrders = [];

        $em = $this->getDoctrine()->getManager()->getRepository(Order::class);
        $orders = $em->findBy(array('status' => 'pending'));

        foreach ($orders as $order) {
            $orderTimeStamp =$order->getCreatedAt()->getTimestamp();
            $result = $timestamp- $orderTimeStamp ;
            if ($result < 5) {
                array_push($recentOrders,$order);
            }
        }

        $response = new Response($this->serializer->serialize($recentOrders, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]));
        $response->headers->set('Content-Type', 'application/json');
        $this->firstInit = 1;
        return $response;
    }
    /**
     * @Route("/finishOrder/{id}", name="finishOrder")
     */
    public function finishOrder($id)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository(Order::class)->findOneBy(array('id' => $id));
        $order->setStatus('finished');
        $em->merge($order);
        $em->flush();

        return new Response('ok');
    }
    /**
     * @Route("/generateOrder", name="generateOrder")
     */
    public function generateOrder() {

        $em = $this->getDoctrine()->getManager();
      $productos = get_object_vars(json_decode($_POST["carrito"]));
      $order = new Order();
      $order->setStatus($_POST['status']);
      $em->persist($order);
      $em->flush();
      foreach ($productos["_productos"] as $producto) {
          $producto = get_object_vars($producto);
          $productReal = $em->getRepository(Product::class)->findOneBy(array('id' => $producto['_id']));
          $orderProduct = new OrderProduct();
          $orderProduct->setOrderObject($order);
          $orderProduct->setProduct($productReal);
          $orderProduct->setQuantity($producto['_quantity']);
          $em->persist($orderProduct);
          $em->flush();
      }
      return new Response('ok');

    }


}
