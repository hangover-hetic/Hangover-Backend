<?php

namespace App\Repository;

use App\Entity\OrganisationTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrganisationTeam|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrganisationTeam|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrganisationTeam[]    findAll()
 * @method OrganisationTeam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganisationTeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrganisationTeam::class);
    }

    // /**
    //  * @return OrganisationTeam[] Returns an array of OrganisationTeam objects
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
    public function findOneBySomeField($value): ?OrganisationTeam
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
