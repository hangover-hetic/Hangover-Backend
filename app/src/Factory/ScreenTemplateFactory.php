<?php

namespace App\Factory;

use App\Entity\ScreenTemplate;
use App\Repository\ScreenTemplateRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<ScreenTemplate>
 *
 * @method static ScreenTemplate|Proxy createOne(array $attributes = [])
 * @method static ScreenTemplate[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static ScreenTemplate|Proxy find(object|array|mixed $criteria)
 * @method static ScreenTemplate|Proxy findOrCreate(array $attributes)
 * @method static ScreenTemplate|Proxy first(string $sortedField = 'id')
 * @method static ScreenTemplate|Proxy last(string $sortedField = 'id')
 * @method static ScreenTemplate|Proxy random(array $attributes = [])
 * @method static ScreenTemplate|Proxy randomOrCreate(array $attributes = [])
 * @method static ScreenTemplate[]|Proxy[] all()
 * @method static ScreenTemplate[]|Proxy[] findBy(array $attributes)
 * @method static ScreenTemplate[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static ScreenTemplate[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ScreenTemplateRepository|RepositoryProxy repository()
 * @method ScreenTemplate|Proxy create(array|callable $attributes = [])
 */
final class ScreenTemplateFactory extends ModelFactory
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
            // ->afterInstantiate(function(ScreenTemplate $screenTemplate): void {})
        ;
    }

    protected static function getClass(): string
    {
        return ScreenTemplate::class;
    }
}
