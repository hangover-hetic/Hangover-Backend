<?php

namespace App\Repository;

use App\Entity\Organisator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Organisator|null find($id, $lockMode = null, $lockVersion = null)
 * @method Organisator|null findOneBy(array $criteria, array $orderBy = null)
 * @method Organisator[]    findAll()
 * @method Organisator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganisatorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Organisator::class);
    }

    // /**
    //  * @return Organisator[] Returns an array of Organisator objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Organisator
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
