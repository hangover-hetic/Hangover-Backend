<?php

namespace App\Factory;

use App\Entity\UserFestival;
use App\Repository\UserFestivalRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<UserFestival>
 *
 * @method static UserFestival|Proxy createOne(array $attributes = [])
 * @method static UserFestival[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static UserFestival|Proxy find(object|array|mixed $criteria)
 * @method static UserFestival|Proxy findOrCreate(array $attributes)
 * @method static UserFestival|Proxy first(string $sortedField = 'id')
 * @method static UserFestival|Proxy last(string $sortedField = 'id')
 * @method static UserFestival|Proxy random(array $attributes = [])
 * @method static UserFestival|Proxy randomOrCreate(array $attributes = [])
 * @method static UserFestival[]|Proxy[] all()
 * @method static UserFestival[]|Proxy[] findBy(array $attributes)
 * @method static UserFestival[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static UserFestival[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static UserFestivalRepository|RepositoryProxy repository()
 * @method UserFestival|Proxy create(array|callable $attributes = [])
 */
final class UserFestivalFactory extends ModelFactory
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
        return UserFestival::class;
    }
}
