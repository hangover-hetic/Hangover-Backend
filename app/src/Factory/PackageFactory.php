<?php

namespace App\Factory;

use App\Entity\Package;
use App\Repository\PackageRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Package>
 *
 * @method static Package|Proxy createOne(array $attributes = [])
 * @method static Package[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Package|Proxy find(object|array|mixed $criteria)
 * @method static Package|Proxy findOrCreate(array $attributes)
 * @method static Package|Proxy first(string $sortedField = 'id')
 * @method static Package|Proxy last(string $sortedField = 'id')
 * @method static Package|Proxy random(array $attributes = [])
 * @method static Package|Proxy randomOrCreate(array $attributes = [])
 * @method static Package[]|Proxy[] all()
 * @method static Package[]|Proxy[] findBy(array $attributes)
 * @method static Package[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Package[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static PackageRepository|RepositoryProxy repository()
 * @method Package|Proxy create(array|callable $attributes = [])
 */
final class PackageFactory extends ModelFactory
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
            'name' => self::faker()->word(),
            'price' => self::faker()->randomFloat(2, 5, 30),
            'pictureNumber' => self::faker()->numberBetween(5, 100),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Package $package): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Package::class;
    }
}
