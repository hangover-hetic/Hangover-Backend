<?php

namespace App\Repository;

use App\Entity\Inscription;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Inscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inscription[]    findAll()
 * @method Inscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inscription::class);
    }

    // /**
    //  * @return Inscription[] Returns an array of UserFestival objects
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
    public function findOneBySomeField($value): ?Inscription
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findNextByUser(User $user)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.relatedUser = :user')
            ->andWhere('u.startDate > :now')
            ->setParameter('user', $user)
            ->setParameter('now', new \DateTime())
            ->orderBy('u.startDate', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult();
    }

    public function findByDate()
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.startDate > :today')
            ->andWhere('u.endDate < :today')
            ->setParameter('today', new \DateTime())
            ->orderBy('u.startDate', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }
}
