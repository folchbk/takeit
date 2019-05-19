<?php

namespace App\Controller;

use App\Entity\Disccount;
use App\Form\DisccountType;
use App\Repository\DisccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DisccountController extends AbstractController
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
     * @Route("/getDisccount/{code}", name="disccount")
     */
    public function index($code)
    {
        $em = $this->getDoctrine()->getManager()->getRepository(Disccount::class);
        $disccount = $em->findOneBy(array('code' => $code));
        if ($disccount) {
            $campos = [$disccount->getCode(), $disccount->getQuantity()];
            $response = new Response(json_encode($campos));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        return new Response('false');
    }
}
