<?php

namespace App\Repository;

use App\Entity\ScreenTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ScreenTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScreenTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScreenTemplate[]    findAll()
 * @method ScreenTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScreenTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ScreenTemplate::class);
    }

    // /**
    //  * @return ScreenTemplate[] Returns an array of ScreenTemplate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ScreenTemplate
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
