<?php

namespace App\Controller;

use App\Entity\HelpRequest;
use App\Entity\Table;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class HelpRequestController extends AbstractController
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
     * @Route("/addHelpRequest", name="help_request")
     */
    public function addHelpRequest(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $table = $em->getRepository(Table::class)->findOneBy(array('id' => $request->cookies->get('table')));
        if ($table) {
            $helpRequest = new HelpRequest();
            $helpRequest->setFromTable($table);
            $helpRequest->setStatus($_POST['status']);
            $em->persist($helpRequest);
            $em->flush();
        }
        return new Response(200);
    }
    /**
     * @Route("/attendHelpRequest/{id}", name="attend-help_request")
     */
    public function attendHelpRequest($id)
    {
        $em = $this->getDoctrine()->getManager();
        $helpRequest = $em->getRepository(HelpRequest::class)->findOneBy(array('id' => $id));
        $helpRequest->setStatus('finished');
        $em->persist($helpRequest);
        $em->flush();

        return new Response('ok');
    }
    /**
     * @Route("/getHelpRequest", name="get-help_request")
     */
    public function getHelpRequest()
    {
        $date = new \DateTime("now");
        $timestamp = $date->getTimestamp();
        $recentRequest = [];
        $em = $this->getDoctrine()->getManager();

        $helpRequest = $em->getRepository(HelpRequest::class)->findBy(array('status' => 'pending'));

        foreach ($helpRequest as $singleHelp) {
            $orderTimeStamp =$singleHelp->getCreatedAt()->getTimestamp();
            $result = $timestamp- $orderTimeStamp ;
            if ($result < 5) {
                array_push($recentRequest,$singleHelp);
            }
        }
        $response = new Response($this->serializer->serialize($recentRequest, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]));
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }

}
