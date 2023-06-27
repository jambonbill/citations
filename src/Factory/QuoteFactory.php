<?php

namespace App\Factory;

use App\Entity\Quote;
use App\Repository\QuoteRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Quote>
 *
 * @method        Quote|Proxy                     create(array|callable $attributes = [])
 * @method static Quote|Proxy                     createOne(array $attributes = [])
 * @method static Quote|Proxy                     find(object|array|mixed $criteria)
 * @method static Quote|Proxy                     findOrCreate(array $attributes)
 * @method static Quote|Proxy                     first(string $sortedField = 'id')
 * @method static Quote|Proxy                     last(string $sortedField = 'id')
 * @method static Quote|Proxy                     random(array $attributes = [])
 * @method static Quote|Proxy                     randomOrCreate(array $attributes = [])
 * @method static QuoteRepository|RepositoryProxy repository()
 * @method static Quote[]|Proxy[]                 all()
 * @method static Quote[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Quote[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Quote[]|Proxy[]                 findBy(array $attributes)
 * @method static Quote[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Quote[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class QuoteFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            //'createdBy' => 1,
            'data' => self::faker()->realText(128),
            'explanation' => self::faker()->text(64),
            'info' => self::faker()->text(64),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Quote $quote): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Quote::class;
    }
}
