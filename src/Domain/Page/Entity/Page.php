<?php

namespace App\Domain\Page\Entity;

use App\Domain\Application\Entity\Traits\IdentifiableTrait;
use App\Domain\Application\Entity\Traits\ToggleableTrait;
use App\Domain\Page\Repository\PageRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\PropertyAccess\PropertyAccess;

use function Symfony\Component\String\u;

/**
 * @method PageTranslation translate()
 */
#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ORM\Table('`page_pages`')]
#[Gedmo\TranslationEntity(class: PageTranslation::class)]
class Page implements TranslatableInterface
{
    use IdentifiableTrait;
    use TimestampableEntity;
    use ToggleableTrait;
    use TranslatableTrait;

    public function __call($method, $arguments)
    {
        echo $method;

        if (u($method)->startsWith('set')) {
            return PropertyAccess::createPropertyAccessor()->setValue($this->translate(), $method, $arguments);
        }

        return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }
}
