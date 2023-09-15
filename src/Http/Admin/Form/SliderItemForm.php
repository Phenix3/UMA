<?php

declare(strict_types=1);

namespace App\Http\Admin\Form;

use App\Domain\Slider\Entity\SliderItem;
use App\Http\Admin\Form\Field\SliderChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SliderItemForm extends AbstractType implements DataTransformerInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $builder->addViewTransformer($this);
        $builder
            ->add('title', TextType::class)
            ->add('link', UrlType::class)
            ->add('imageFile', VichImageType::class)
            ->add('description', TextareaType::class)
            ->add('slider', SliderChoiceType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'data_class' => SliderItem::class,
            ])
        ;
    }

    public function transform(mixed $value): ?SliderItem
    {
        if (null === $value) {
            return null;
        }

        // dd('Transform', $value->getEntity());
        return $value->getEntity();
    }

    public function reverseTransform(mixed $value): void
    {
        dd('reverseTransform', $value->getEntity());
    }
}
