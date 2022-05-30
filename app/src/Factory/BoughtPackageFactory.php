<?php

namespace App\Factory;

use App\Entity\BoughtPackage;
use App\Repository\BoughtPackageRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<BoughtPackage>
 *
 * @method static BoughtPackage|Proxy createOne(array $attributes = [])
 * @method static BoughtPackage[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static BoughtPackage|Proxy find(object|array|mixed $criteria)
 * @method static BoughtPackage|Proxy findOrCreate(array $attributes)
 * @method static BoughtPackage|Proxy first(string $sortedField = 'id')
 * @method static BoughtPackage|Proxy last(string $sortedField = 'id')
 * @method static BoughtPackage|Proxy random(array $attributes = [])
 * @method static BoughtPackage|Proxy randomOrCreate(array $attributes = [])
 * @method static BoughtPackage[]|Proxy[] all()
 * @method static BoughtPackage[]|Proxy[] findBy(array $attributes)
 * @method static BoughtPackage[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static BoughtPackage[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static BoughtPackageRepository|RepositoryProxy repository()
 * @method BoughtPackage|Proxy create(array|callable $attributes = [])
 */
final class BoughtPackageFactory extends ModelFactory
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
            'number' => self::faker()->randomNumber(),
            'pictureNumber' => self::faker()->randomNumber(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(BoughtPackage $boughtPackage): void {})
        ;
    }

    protected static function getClass(): string
    {
        return BoughtPackage::class;
    }
}
