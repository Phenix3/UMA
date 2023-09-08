<?php

namespace App\Http\Admin\Form\Field;

use App\Domain\Slider\Entity\Slider;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SliderChoiceType extends EntityType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver
            ->setDefaults([
                'class' => Slider::class,
                'multiple' => false,
                'attr' => [
                    // 'is' => 'select-select2',
                    'class' => 'js-select2',
                ],
            ]);
    }
}
