<?php

namespace App\Controller;

use App\Entity\ServerItem;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbstractServerItemController extends AbstractController

{
    protected $defaultFilterValues = [
        'storage' => [0, 250, 500, 1*1024, 2*1024, 3*1024, 4*1024, 8*1024, 12*1024, 24*1024, 48*1024, 72*1024],
        'ram' => [2, 4, 8, 12, 16, 24, 32, 48, 64, 96],
        'storageType' => ['SAS', 'SATA', 'SSD'],
        'location' => null
    ];

    /**
     * @param ManagerRegistry $doctrine
     * @return void
     */
    private function setAvailableLocations(ManagerRegistry $doctrine): void
    {
        $this->defaultFilterValues['location'] = array_column($doctrine->getRepository(ServerItem::class)->getAvailableLocations(), 'location');
    }

    /**
     * @param ManagerRegistry $doctrine
     * @return ServerItem[]
     */
    protected function getAllServerItems(ManagerRegistry $doctrine): array
    {
        $this->setAvailableLocations($doctrine);
        return $doctrine->getRepository(ServerItem::class)->findAll();
    }

    /**
     * @param ManagerRegistry $doctrine
     * @param array $filters
     * @return ServerItem
     */
    protected function getFilteredServerItems(ManagerRegistry $doctrine, array $filters): array
    {
        $this->setAvailableLocations($doctrine);
        return $doctrine->getRepository(ServerItem::class)->findByFilters($filters);
    }
}
