<?php

namespace App\Repository;

use App\Entity\Thread;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ThreadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Thread::class);
    }

    public function searchByKeyword(string $keyword): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.title LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%')
            ->getQuery()
            ->getResult();
    }

    public function sortByCreatedAtDescending(): array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.createdat', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
