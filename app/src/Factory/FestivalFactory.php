<?php

namespace App\Factory;

use App\Entity\Festival;
use App\Repository\FestivalRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Festival>
 *
 * @method static Festival|Proxy createOne(array $attributes = [])
 * @method static Festival[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Festival|Proxy find(object|array|mixed $criteria)
 * @method static Festival|Proxy findOrCreate(array $attributes)
 * @method static Festival|Proxy first(string $sortedField = 'id')
 * @method static Festival|Proxy last(string $sortedField = 'id')
 * @method static Festival|Proxy random(array $attributes = [])
 * @method static Festival|Proxy randomOrCreate(array $attributes = [])
 * @method static Festival[]|Proxy[] all()
 * @method static Festival[]|Proxy[] findBy(array $attributes)
 * @method static Festival[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Festival[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static FestivalRepository|RepositoryProxy repository()
 * @method Festival|Proxy create(array|callable $attributes = [])
 */
final class FestivalFactory extends ModelFactory
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
            'description' => self::faker()->text(),
            'start_date' => self::faker()->dateTimeBetween('-2 years', '-1 years'), // TODO add DATETIME ORM type manually
            'end_date' => self::faker()->dateTimeBetween('-1 year', 'now'), // TODO add DATETIME ORM type manually
            'programmation' => [],
            'map' => [],
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Festival $festival): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Festival::class;
    }
}
