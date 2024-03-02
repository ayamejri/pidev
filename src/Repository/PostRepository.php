<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * Search posts by keyword in title or description.
     *
     * @param string $keyword The keyword to search for
     * @return Post[] An array of Post objects matching the search keyword
     */
    public function searchByKeyword(string $keyword): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.title LIKE :keyword OR p.description LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%')
            ->getQuery()
            ->getResult();
    }

    /**
     * Get posts sorted by created date in descending order.
     *
     * @return Post[] An array of Post objects sorted by created date descending
     */
    public function sortByCreatedAtDescending(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAT', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
