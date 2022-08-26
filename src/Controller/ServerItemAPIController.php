<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ServerItemAPIController extends AbstractServerItemController

{
    /**
     * @Route("/api/server/item/list", name="app_server_item_list_api")
     */
    public function list(ManagerRegistry $doctrine): JsonResponse
    {
        return new JsonResponse($this->getAllServerItems($doctrine));
    }

    /**
     * @Route("/api/server/item/list/filter", name="app_server_item_list_filter_api")
     */
    public function listFilter(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $filters = $request->request->all();
        return new JsonResponse($this->getFilteredServerItems($doctrine, $filters));
    }
}
