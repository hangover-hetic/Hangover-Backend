<?php

namespace App\Factory;

use App\Entity\Licence;
use App\Repository\LicenceRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Licence>
 *
 * @method static Licence|Proxy createOne(array $attributes = [])
 * @method static Licence[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Licence|Proxy find(object|array|mixed $criteria)
 * @method static Licence|Proxy findOrCreate(array $attributes)
 * @method static Licence|Proxy first(string $sortedField = 'id')
 * @method static Licence|Proxy last(string $sortedField = 'id')
 * @method static Licence|Proxy random(array $attributes = [])
 * @method static Licence|Proxy randomOrCreate(array $attributes = [])
 * @method static Licence[]|Proxy[] all()
 * @method static Licence[]|Proxy[] findBy(array $attributes)
 * @method static Licence[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Licence[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static LicenceRepository|RepositoryProxy repository()
 * @method Licence|Proxy create(array|callable $attributes = [])
 */
final class LicenceFactory extends ModelFactory
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
            'start_date' => self::faker()->dateTimeBetween('-1 year', '-1 day'),
            'end_date' => self::faker()->dateTimeBetween('+1 year', '+2 years'),
            'isBuyed' => true,
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Licence $licence): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Licence::class;
    }
}
