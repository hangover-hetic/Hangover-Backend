<?php

namespace App\Factory;

use App\Entity\Style;
use App\Repository\StyleRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Style>
 *
 * @method static Style|Proxy createOne(array $attributes = [])
 * @method static Style[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Style|Proxy find(object|array|mixed $criteria)
 * @method static Style|Proxy findOrCreate(array $attributes)
 * @method static Style|Proxy first(string $sortedField = 'id')
 * @method static Style|Proxy last(string $sortedField = 'id')
 * @method static Style|Proxy random(array $attributes = [])
 * @method static Style|Proxy randomOrCreate(array $attributes = [])
 * @method static Style[]|Proxy[] all()
 * @method static Style[]|Proxy[] findBy(array $attributes)
 * @method static Style[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Style[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static StyleRepository|RepositoryProxy repository()
 * @method Style|Proxy create(array|callable $attributes = [])
 */
final class StyleFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        $styles = ["rap","pop","classique", "jazz", "hyperpop", "métal", "rock", "reggae", "dub"];
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'label' => $styles[array_rand($styles)],
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Tag $tag): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Style::class;
    }
}
