<?php

namespace App\Repository;

use App\Entity\Wajdi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Wajdi>
 *
 * @method Wajdi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wajdi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wajdi[]    findAll()
 * @method Wajdi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WajdiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wajdi::class);
    }

//    /**
//     * @return Wajdi[] Returns an array of Wajdi objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Wajdi
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
