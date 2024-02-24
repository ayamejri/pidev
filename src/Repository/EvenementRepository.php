<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evenement>
 *
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

//    /**
//     * @return Evenement[] Returns an array of Evenement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Evenement
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }



public function SortByNomEvenement(){
    return $this->createQueryBuilder('e')
        ->orderBy('e.themeEvenement','ASC')
        ->getQuery()
        ->getResult()
        ;
}

public function SortByTypeEvenement()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.typeEvenement','ASC')
        ->getQuery()
        ->getResult()
        ;
}


public function SortBynbrParticipant()
{
    return $this->createQueryBuilder('e')
        ->orderBy('e.nbrParticipant','ASC')
        ->getQuery()
        ->getResult()
        ;
}








public function findBynomEvenement( $themeEvenement)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.themeEvenement LIKE :themeEvenement')
        ->setParameter('themeEvenement','%' .$themeEvenement. '%')
        ->getQuery()
        ->execute();
}

public function findBytypeEvenement( $typeEvenement)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.typeEvenement LIKE :typeEvenement')
        ->setParameter('typeEvenement','%' .$typeEvenement. '%')
        ->getQuery()
        ->execute();
}


public function findBydateDebut( $dateDebut)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.dateDebut LIKE :dateDebut')
        ->setParameter('dateDebut','%' .$dateDebut. '%')
        ->getQuery()
        ->execute();
}
public function findBydateFin( $dateFin)
{
    return $this-> createQueryBuilder('e')
        ->andWhere('e.dateFin LIKE :dateFin')
        ->setParameter('dateFin','%' .$dateFin. '%')
        ->getQuery()
        ->execute();
}

}
