<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServerItemController extends AbstractServerItemController

{
    /**
     * @Route("/server/item/list", name="app_server_item_list")
     */
    public function list(): Response
    {
        return $this->render('server_item/list.html.twig', []);
    }
}
