<?php

namespace App\Repository;

use App\Entity\ServerList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use function Webmozart\Assert\Tests\StaticAnalysis\length;

/**
 * @extends ServiceEntityRepository<ServerList>
 *
 * @method ServerList|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServerList|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServerList[]    findAll()
 * @method ServerList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServerListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServerList::class);
    }

    public function add(ServerList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ServerList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return ServerList Returns the ServerList entity which was created latest
     * @throws NoResultException
     */
    public function findOneByCreatedAtLatest(): ?ServerList
    {
        $foundElementsArray = $this->createQueryBuilder('s')
            ->orderBy('s.createdAt', 'DESC')
            ->getQuery()
            ->setMaxResults(1)
            ->getResult();
        if (count($foundElementsArray) == 1) {
            return $foundElementsArray[0];
        } else {
            throw new NoResultException('No uploaded file found');
        }
    }

//    /**
//     * @return ServerList[] Returns an array of ServerList objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ServerList
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}