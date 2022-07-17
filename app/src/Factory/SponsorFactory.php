<?php

namespace App\Factory;

use App\Entity\Sponsor;
use App\Repository\SponsorRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Sponsor>
 *
 * @method static Sponsor|Proxy createOne(array $attributes = [])
 * @method static Sponsor[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Sponsor|Proxy find(object|array|mixed $criteria)
 * @method static Sponsor|Proxy findOrCreate(array $attributes)
 * @method static Sponsor|Proxy first(string $sortedField = 'id')
 * @method static Sponsor|Proxy last(string $sortedField = 'id')
 * @method static Sponsor|Proxy random(array $attributes = [])
 * @method static Sponsor|Proxy randomOrCreate(array $attributes = [])
 * @method static Sponsor[]|Proxy[] all()
 * @method static Sponsor[]|Proxy[] findBy(array $attributes)
 * @method static Sponsor[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Sponsor[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static SponsorRepository|RepositoryProxy repository()
 * @method Sponsor|Proxy create(array|callable $attributes = [])
 */
final class SponsorFactory extends ModelFactory
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
            'name' => self::faker()->company(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Sponsor $sponsor): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Sponsor::class;
    }
}
