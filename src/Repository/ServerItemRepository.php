<?php

namespace App\Repository;

use App\Entity\ServerItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServerItem>
 *
 * @method ServerItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServerItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServerItem[]    findAll()
 * @method ServerItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServerItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServerItem::class);
    }

    public function add(ServerItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ServerItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function removeAll(bool $flush = false): void
    {
        $this->createQueryBuilder('s')
            ->delete('App:ServerItem', 'server_item')
            ->getQuery()
            ->getResult();

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
