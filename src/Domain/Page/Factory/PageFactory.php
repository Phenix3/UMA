<?php

namespace App\Domain\Page\Factory;

use App\Domain\Page\Entity\Page;
use App\Domain\Page\Repository\PageRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Page>
 *
 * @method        Page|Proxy                     create(array|callable $attributes = [])
 * @method static Page|Proxy                     createOne(array $attributes = [])
 * @method static Page|Proxy                     find(object|array|mixed $criteria)
 * @method static Page|Proxy                     findOrCreate(array $attributes)
 * @method static Page|Proxy                     first(string $sortedField = 'id')
 * @method static Page|Proxy                     last(string $sortedField = 'id')
 * @method static Page|Proxy                     random(array $attributes = [])
 * @method static Page|Proxy                     randomOrCreate(array $attributes = [])
 * @method static PageRepository|RepositoryProxy repository()
 * @method static Page[]|Proxy[]                 all()
 * @method static Page[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Page[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Page[]|Proxy[]                 findBy(array $attributes)
 * @method static Page[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Page[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class PageFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private SluggerInterface $slugger)
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
            'title' => self::faker()->sentence,
            'description' => self::faker()->paragraph(),
            'content' => self::faker()->paragraphs(4, true),
            'metaDescription' => self::faker()->paragraph,
            'metaKeywords' => self::faker()->paragraph,
            'createdAt' => self::faker()->dateTime(),
            'enabled' => self::faker()->boolean(),
            'updatedAt' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(function (Page $page): void {
                $page->translate()->setSlug(mb_strtolower($this->slugger->slug($page->getTitle())));
            })
        ;
    }

    protected static function getClass(): string
    {
        return Page::class;
    }
}
