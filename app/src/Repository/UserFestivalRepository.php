<?php

namespace App\Repository;

use App\Entity\UserFestival;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserFestival|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserFestival|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserFestival[]    findAll()
 * @method UserFestival[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserFestivalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserFestival::class);
    }

    // /**
    //  * @return UserFestival[] Returns an array of UserFestival objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserFestival
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
