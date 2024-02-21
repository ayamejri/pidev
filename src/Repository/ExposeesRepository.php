<?php

namespace App\Repository;

use App\Entity\Exposees;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Exposees>
 *
 * @method Exposees|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exposees|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exposees[]    findAll()
 * @method Exposees[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExposeesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exposees::class);
    }

//    /**
//     * @return Exposees[] Returns an array of Exposees objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Exposees
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
