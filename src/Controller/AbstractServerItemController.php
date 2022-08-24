<?php

namespace App\Controller;

use App\Entity\ServerItem;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbstractServerItemController extends AbstractController

{
    /**
     * @param ManagerRegistry $doctrine
     * @return ServerItem[]
     */
    protected function getAllServerItems(ManagerRegistry $doctrine): array
    {
        return $doctrine->getRepository(ServerItem::class)->findAll();
    }

    /**
     * @param ManagerRegistry $doctrine
     * @param array $filters
     * @return ServerItem
     */
    protected function getFilteredServerItems(ManagerRegistry $doctrine, array $filters): array
    {
        return $doctrine->getRepository(ServerItem::class)->findByFilters($filters);
    }
}
