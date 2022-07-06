<?php

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Festival;
use App\Entity\Inscription;
use App\Service\JwtUser;
use Doctrine\ORM\QueryBuilder;

final class InscriptionsFilter implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{

    private JwtUser $jwtUser;

    public function __construct(JwtUser $jwtUser)
    {
        $this->jwtUser = $jwtUser;
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null): void
    {
        if ($operationName === "get_inscriptions")
            $this->addWhere($queryBuilder, $resourceClass);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = []): void
    {
//        $this->addWhere($queryBuilder, $resourceClass);
    }

    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        if (Inscription::class !== $resourceClass) {
            // don't filter
            return;
        }
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->andWhere(sprintf('%s.relatedUser = :user', $rootAlias));
        $queryBuilder->setParameter('user', $this->jwtUser->getActualUser());
    }
}
