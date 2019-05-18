<?php

namespace App\Controller;

use App\Entity\Device;
use App\Form\DeviceType;
use App\Repository\DeviceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeviceController extends AbstractController
{
    /**
     * @Route("/backoffice/device/list", name="device_index", methods={"GET"})
     */
    public function index(DeviceRepository $deviceRepository): Response
    {
        return $this->render('device/index.html.twig', [
            'devices' => $deviceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/", name="device_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tableId = $request->cookies->get('table');

        if ($tableId == null) {
            $device = new Device();
            $form = $this->createForm(DeviceType::class, $device);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $repoTables = $entityManager->getRepository('App\Entity\Table');
                $hashCode = $form->get('hashCode')->getData();
                $linkedTable = $repoTables->findOneByHash($hashCode);

                if ($linkedTable) {
                    $device->setLinkedTable($linkedTable);
                    $device->setName('Device' . $linkedTable->getTableCode());
                    $entityManager->persist($device);
                    $entityManager->flush();

                    $response = new Response();
                    $table_cookie = new Cookie('table', $linkedTable->getId(), strtotime('now + 1 year'));
                    $deal_cookie = new Cookie('local', $linkedTable->getLocal()->getId(), strtotime('now + 1 year'));
                    $response->headers->setCookie($table_cookie);
                    $response->headers->setCookie($deal_cookie);
                    $response->send();

                    return $this->redirect("/cart");
                } else {
                    return $this->redirectToRoute('device_new');
                }
            }
            return $this->render('device/new.html.twig', [
                'device' => $device,
                'form' => $form->createView(),
            ]);
        }
        return $this->redirect("/cart");
    }

    /**
     * @Route("/backoffice/device/{id}", name="device_show", methods={"GET"})
     */
    public
    function show(Device $device): Response
    {
        return $this->render('device/show.html.twig', [
            'device' => $device,
        ]);
    }

    /**
     * @Route("/backoffice/device/{id}/edit", name="device_edit", methods={"GET","POST"})
     */
    public
    function edit(Request $request, Device $device): Response
    {
        $form = $this->createForm(DeviceType::class, $device);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('device_index', [
                'id' => $device->getId(),
            ]);
        }

        return $this->render('device/edit.html.twig', [
            'device' => $device,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/backoffice/device/{id}", name="device_delete", methods={"DELETE"})
     */
    public
    function delete(Request $request, Device $device): Response
    {
        if ($this->isCsrfTokenValid('delete' . $device->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($device);
            $entityManager->flush();
        }

        return $this->redirectToRoute('device_index');
    }
}
