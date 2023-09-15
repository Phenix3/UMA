<?php

declare(strict_types=1);

namespace App\Http\Admin\Form\Field;

use App\Domain\Blog\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryChoiceType extends EntityType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver
            ->setDefaults([
                'class' => Category::class,
                'multiple' => true,
                'attr' => [
                    // 'is' => 'select-select2',
                    'class' => 'js-select2',
                ],
            ])
        ;
    }
}
