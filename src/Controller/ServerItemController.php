<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServerItemController extends AbstractController
{
    /**
     * @Route("/server/item", name="app_server_item")
     */
    public function index(): Response
    {
        return $this->render('server_item/index.html.twig', [
            'controller_name' => 'ServerItemController',
        ]);
    }
}
