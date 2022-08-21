<?php

namespace App\Controller;

use App\Entity\ServerItem;
use App\Repository\ServerItemRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServerItemController extends AbstractServerItemController

{
    /**
     * @Route("/server/item/list", name="app_server_item_list")
     */
    public function list(ManagerRegistry $doctrine): Response
    {
        return $this->render('server_item/list.html.twig', [
            'server_items' => $doctrine->getRepository(ServerItem::class)->findAll()
        ]);
    }
}
