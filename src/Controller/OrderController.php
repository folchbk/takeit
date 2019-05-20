<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Deal;
use App\Entity\Order;
use App\Form\OrderType;
use App\Entity\Table;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\OrderProduct;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/")
 */
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
     * @Route("/backoffice/order/", name="order_index", methods={"GET"})
     */
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/backoffice/order/new", name="order_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            foreach ($order->getOrderProducts() as $orderProduct) {
                $orderProduct->setOrderObject($order);
            }

            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('order_index');
        }

        return $this->render('order/new.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/backoffice/order/{id}", name="order_show", methods={"GET"})
     */
    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("/backoffice/order/{id}/edit", name="order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Order $order): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('order_index', [
                'id' => $order->getId(),
            ]);
        }

        return $this->render('order/edit.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/backoffice/order/{id}", name="order_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Order $order): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('order_index');
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
        $orders = $em->findByStatus($_POST['status']);

        foreach ($orders as $order) {
            $orderTimeStamp =$order->getCreatedAt()->getTimestamp();
            $orderTimeStampUpdate =$order->getUpdatedAt()->getTimestamp();
            $result = $timestamp- $orderTimeStamp ;
            $resultUpdate = $timestamp- $orderTimeStampUpdate;
            if ($result < 5 || $resultUpdate < 5) {
                array_push($recentOrders,$order);
            }
        }
        $finalArray = [];
        foreach ($recentOrders as $recentOrder) {
            $array['id'] = $recentOrder->getId();
            $array['orderProducts'] = [];
            foreach ($recentOrder->getOrderProducts() as $orderProduct) {
                $product['quantity'] = $orderProduct->getQuantity();
                $product['name'] = $orderProduct->getProduct()->getName();
                array_push($array['orderProducts'] ,$product);
            }
            $array['totalPrice'] = $recentOrder->getTotalPrice();
            $array['tableCode'] = $recentOrder->getClient()->getTableObject()->getTableCode();
            array_push($finalArray,$array);
        }
//
//        $json = $this->serializer->serialize($finalArray, 'json', [
//            'circular_reference_handler' => function ($object) {
//                return $object->getId();
//            }
//        ]);
//        var_dump($json);
//        $response = new Response($this->serializer->serialize($recentOrders, 'json', [
//            'circular_reference_handler' => function ($object) {
//                return $object->getId();
//            }
//        ]));
        $response = new Response($this->serializer->serialize($finalArray, 'json', [ 'circular_reference_handler' => function ($object) {return $object->getId();}]));
        $response->headers->set('Content-Type', 'application/json');
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
        $this->updateStock($order);

        return new Response('ok');
    }

    public function updateStock($order) {
        $em = $this->getDoctrine()->getManager();
        foreach ($order->getOrderProducts() as $product) {
            $quantity = $product->getQuantity();
            $ingredientes = $product->getProduct()->getProductIngredients();
            foreach ($ingredientes as $ingredient) {
                $quantityInProduct = $ingredient->getQuantity();
                $totalQuantity = $quantityInProduct * $quantity;
                $ingrediente = $ingredient->getIngredient();
                $ingrediente->setStock($ingrediente->getStock() - $totalQuantity);
                $em->merge($ingrediente);
                $em->flush();
            }
        }
    }
    /**
    * @Route("/deleteOrder/{id}", name="deleteOrder")
    */
    public function deleteOrder($id)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository(Order::class)->findOneBy(array('id' => $id));
        $order->setStatus('deleted');
        $em->merge($order);
        $em->flush();

        return new Response('ok');
    }

    /**
     * @Route("/generateOrder", name="generateOrder")
     */
    public function generateOrder(Request $request) {
        if (isset($_POST['from'])) {}
        $em = $this->getDoctrine()->getManager();
        $table = $em->getRepository(Table::class)->findOneBy(array('id' => $request->cookies->get('table')));
        if ($table) {
          $client = new Client();
          $client->setTableObject($table);
            $em->persist($client);
            $em->flush();

          $productos = get_object_vars(json_decode($_POST["carrito"]));
          $order = new Order();
          $order->setStatus($_POST['status']);
          $order->setClient($client);
          $order->setTotalPrice($productos['_totalPrice']);
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
    /**
     * @Route("/changeStatus/{id}", name="changeStatus")
     */
    public function changeStatus($id) {

        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository(Order::class)->findOneBy(array('id' => $id));
        $order->setStatus($_POST['status']);
        $order->setUpdatedAt(new \DateTime("now"));
        $em->merge($order);
        $em->flush();

        return new Response('ok');

    }
}
