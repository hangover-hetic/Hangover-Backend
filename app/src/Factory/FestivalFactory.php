<?php

namespace App\Factory;

use App\Entity\Festival;
use App\Repository\FestivalRepository;
use Carbon\Carbon;
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
        $startDate = self::faker()->dateTimeBetween('now', '1 years');
        $festivalsName = ["Hellfest", "No logo", "Les vieilles charrues", "Le cabaret vert", "Eurockéenes", "Coachella", "Burning Man"];
        return [
            'name' => $festivalsName[array_rand($festivalsName)],
            'description' => self::faker()->text(),
            'start_date' => $startDate,
            'end_date' => Carbon::create($startDate)->addDays(rand(1, 5)),
            'programmation' => [],
            'map' => [],
            'location' => self::faker()->city,
            "link" => self::faker()->url(),
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
