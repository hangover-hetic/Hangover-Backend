<?php

namespace App\Factory;

use App\Entity\Friendship;
use App\Repository\FriendshipRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Friendship>
 *
 * @method static Friendship|Proxy createOne(array $attributes = [])
 * @method static Friendship[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Friendship|Proxy find(object|array|mixed $criteria)
 * @method static Friendship|Proxy findOrCreate(array $attributes)
 * @method static Friendship|Proxy first(string $sortedField = 'id')
 * @method static Friendship|Proxy last(string $sortedField = 'id')
 * @method static Friendship|Proxy random(array $attributes = [])
 * @method static Friendship|Proxy randomOrCreate(array $attributes = [])
 * @method static Friendship[]|Proxy[] all()
 * @method static Friendship[]|Proxy[] findBy(array $attributes)
 * @method static Friendship[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Friendship[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static FriendshipRepository|RepositoryProxy repository()
 * @method Friendship|Proxy create(array|callable $attributes = [])
 */
final class FriendshipFactory extends ModelFactory
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
            'validated' => self::faker()->boolean(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Friendship $friendship): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Friendship::class;
    }
}
