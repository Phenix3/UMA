<?php

declare(strict_types=1);

namespace App\Domain\Page\Entity;

use App\Domain\Application\Entity\Traits\IdentifiableTrait;
use App\Domain\Application\Entity\Traits\ToggleableTrait;
use App\Domain\Page\Repository\PageRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;

use function Symfony\Component\String\u;

/**
 * @method PageTranslation translate()
 */
#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ORM\Table('`page_pages`')]
#[Gedmo\TranslationEntity(class: PageTranslation::class)]
#[Gedmo\SoftDeleteable()]
class Page implements TranslatableInterface
{
    use IdentifiableTrait;
    use SoftDeleteableEntity;
    use TimestampableEntity;
    use ToggleableTrait;
    use TranslatableTrait;

    #[Assert\Valid()]
    protected $translations;

    public function __call($method, $arguments)
    {
        if (u($method)->startsWith('set')) {
            return PropertyAccess::createPropertyAccessor()->setValue($this->translate(), $method, $arguments);
        }

        return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }

    public function __get($name)
    {
        return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $name);
    }
}
