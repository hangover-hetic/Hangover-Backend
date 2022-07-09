<?php

namespace App\Factory;

use App\Entity\Show;
use App\Repository\ShowRepository;
use Carbon\Carbon;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Show>
 *
 * @method static Show|Proxy createOne(array $attributes = [])
 * @method static Show[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Show|Proxy find(object|array|mixed $criteria)
 * @method static Show|Proxy findOrCreate(array $attributes)
 * @method static Show|Proxy first(string $sortedField = 'id')
 * @method static Show|Proxy last(string $sortedField = 'id')
 * @method static Show|Proxy random(array $attributes = [])
 * @method static Show|Proxy randomOrCreate(array $attributes = [])
 * @method static Show[]|Proxy[] all()
 * @method static Show[]|Proxy[] findBy(array $attributes)
 * @method static Show[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Show[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ShowRepository|RepositoryProxy repository()
 * @method Show|Proxy create(array|callable $attributes = [])
 */
final class ShowFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        $startTime = Carbon::create(self::faker()->datetime());
        $artistName= ["Orelsan", "Claude François", "Johnny Halliday", "Alpha One", "Céline Dion", "Muse"];
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'name' => $artistName[array_rand($artistName)],
            'startTime' => $startTime->toDateTimeImmutable(),
            'endTime' => $startTime->addHour()->toDateTimeImmutable(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this// ->afterInstantiate(function(Show $show): void {})
            ;
    }

    protected static function getClass(): string
    {
        return Show::class;
    }
}
