<?php

namespace App\Factory;

use App\Entity\OrganisationTeam;
use App\Repository\OrganisationTeamRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<OrganisationTeam>
 *
 * @method static OrganisationTeam|Proxy createOne(array $attributes = [])
 * @method static OrganisationTeam[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static OrganisationTeam|Proxy find(object|array|mixed $criteria)
 * @method static OrganisationTeam|Proxy findOrCreate(array $attributes)
 * @method static OrganisationTeam|Proxy first(string $sortedField = 'id')
 * @method static OrganisationTeam|Proxy last(string $sortedField = 'id')
 * @method static OrganisationTeam|Proxy random(array $attributes = [])
 * @method static OrganisationTeam|Proxy randomOrCreate(array $attributes = [])
 * @method static OrganisationTeam[]|Proxy[] all()
 * @method static OrganisationTeam[]|Proxy[] findBy(array $attributes)
 * @method static OrganisationTeam[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static OrganisationTeam[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static OrganisationTeamRepository|RepositoryProxy repository()
 * @method OrganisationTeam|Proxy create(array|callable $attributes = [])
 */
final class OrganisationTeamFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'name' => self::faker()->userName(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(OrganisationTeam $organisationTeam): void {})
        ;
    }

    protected static function getClass(): string
    {
        return OrganisationTeam::class;
    }
}
