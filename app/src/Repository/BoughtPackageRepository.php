<?php

namespace App\Repository;

use App\Entity\BoughtPackage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BoughtPackage|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoughtPackage|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoughtPackage[]    findAll()
 * @method BoughtPackage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoughtPackageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoughtPackage::class);
    }

    // /**
    //  * @return BuyedPackaged[] Returns an array of BuyedPackaged objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BuyedPackaged
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
