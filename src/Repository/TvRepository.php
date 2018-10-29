<?php

namespace App\Repository;

use App\Entity\Tv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tv|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tv|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tv[]    findAll()
 * @method Tv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TvRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tv::class);
    }

//    /**
//     * @return Tv[] Returns an array of Tv objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tv
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
