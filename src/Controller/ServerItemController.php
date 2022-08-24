<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
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
            'server_items' => $this->getAllServerItems($doctrine)
        ]);
    }

    /**
     * @Route("/server/item/list/filter", name="app_server_item_list_filter")
     */
    public function listFilter(ManagerRegistry $doctrine, Request $request): Response
    {
        //TODO create $filters array from POST request data
        //TODO RAM should be an array instead of min and max values
        $filters = [
            'storageMin' => null,
            'storageMax' => null,
            'storageType' => null,
            'ramMin' => null,
            'ramMax' => null,
            'location' => null
        ];
        return $this->render('server_item/list.html.twig', [
            'server_items' => $this->getFilteredServerItems($doctrine, $filters),
            'filters' => $filters
        ]);
    }
}
