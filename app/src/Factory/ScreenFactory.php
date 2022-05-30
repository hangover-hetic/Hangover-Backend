<?php

namespace App\Factory;

use App\Entity\Screen;
use App\Repository\ScreenRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Screen>
 *
 * @method static Screen|Proxy createOne(array $attributes = [])
 * @method static Screen[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Screen|Proxy find(object|array|mixed $criteria)
 * @method static Screen|Proxy findOrCreate(array $attributes)
 * @method static Screen|Proxy first(string $sortedField = 'id')
 * @method static Screen|Proxy last(string $sortedField = 'id')
 * @method static Screen|Proxy random(array $attributes = [])
 * @method static Screen|Proxy randomOrCreate(array $attributes = [])
 * @method static Screen[]|Proxy[] all()
 * @method static Screen[]|Proxy[] findBy(array $attributes)
 * @method static Screen[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Screen[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ScreenRepository|RepositoryProxy repository()
 * @method Screen|Proxy create(array|callable $attributes = [])
 */
final class ScreenFactory extends ModelFactory
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
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Screen $screen): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Screen::class;
    }
}
