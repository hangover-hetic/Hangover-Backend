<?php

namespace App\Factory;

use App\Entity\Inscription;
use App\Repository\InscriptionRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Inscription>
 *
 * @method static Inscription|Proxy createOne(array $attributes = [])
 * @method static Inscription[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Inscription|Proxy find(object|array|mixed $criteria)
 * @method static Inscription|Proxy findOrCreate(array $attributes)
 * @method static Inscription|Proxy first(string $sortedField = 'id')
 * @method static Inscription|Proxy last(string $sortedField = 'id')
 * @method static Inscription|Proxy random(array $attributes = [])
 * @method static Inscription|Proxy randomOrCreate(array $attributes = [])
 * @method static Inscription[]|Proxy[] all()
 * @method static Inscription[]|Proxy[] findBy(array $attributes)
 * @method static Inscription[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Inscription[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static InscriptionRepository|RepositoryProxy repository()
 * @method Inscription|Proxy create(array|callable $attributes = [])
 */
final class InscriptionFactory extends ModelFactory
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
            'ticketPath' => self::faker()->imageUrl(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(UserFestival $userFestival): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Inscription::class;
    }
}
