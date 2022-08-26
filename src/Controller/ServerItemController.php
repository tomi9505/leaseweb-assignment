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
            'serverItems' => $this->getAllServerItems($doctrine),
            'defaultFilterValues' => $this->defaultFilterValues
        ]);
    }

    /**
     * @Route("/server/item/list/filter", name="app_server_item_list_filter")
     */
    public function listFilter(ManagerRegistry $doctrine, Request $request): Response
    {
        $receivedFilterValues = $request->request->all();
        $ramValues = [];
        foreach ($this->defaultFilterValues['storageCapacity'] as $storageCapacity) {
            if (array_key_exists('ramCapacity' . $storageCapacity, $receivedFilterValues)) {
                $ramValues[] = $storageCapacity;
            }
        }

        $filters = [
            'storageMin' => $receivedFilterValues['storageCapacityMin'],
            'storageMax' => $receivedFilterValues['storageCapacityMax'],
            'storageType' => $receivedFilterValues['formFilterSelectStorageType'] == 'None' ? null : $receivedFilterValues['formFilterSelectStorageType'],
            'ramValues' => count($ramValues) == 0 ? null : $ramValues,
            'location' => $receivedFilterValues['formFilterSelectLocation'] == 'None' ? null : $receivedFilterValues['formFilterSelectLocation']
        ];
        return $this->render('server_item/list.html.twig', [
            'serverItems' => $this->getFilteredServerItems($doctrine, $filters),
            'defaultFilterValues' => $this->defaultFilterValues,
            'filters' => $filters
        ]);
    }
}
