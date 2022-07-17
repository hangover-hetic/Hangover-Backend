<?php

namespace App\Factory;

use App\Entity\Organisator;
use App\Repository\OrganisatorRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Organisator>
 *
 * @method static Organisator|Proxy createOne(array $attributes = [])
 * @method static Organisator[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Organisator|Proxy find(object|array|mixed $criteria)
 * @method static Organisator|Proxy findOrCreate(array $attributes)
 * @method static Organisator|Proxy first(string $sortedField = 'id')
 * @method static Organisator|Proxy last(string $sortedField = 'id')
 * @method static Organisator|Proxy random(array $attributes = [])
 * @method static Organisator|Proxy randomOrCreate(array $attributes = [])
 * @method static Organisator[]|Proxy[] all()
 * @method static Organisator[]|Proxy[] findBy(array $attributes)
 * @method static Organisator[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Organisator[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static OrganisatorRepository|RepositoryProxy repository()
 * @method Organisator|Proxy create(array|callable $attributes = [])
 */
final class OrganisatorFactory extends ModelFactory
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
            'isAdministrator' => self::faker()->boolean(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Organisator $organisator): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Organisator::class;
    }
}
