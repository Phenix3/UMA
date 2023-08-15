<?php

namespace App\Http\Admin\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use App\Domain\Slider\Entity\SliderItem;
use App\Http\Admin\Form\Field\SliderChoiceType;
use App\Http\Admin\Data\SliderItemCrudData;

class SliderItemForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
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
                'data_class' => SliderItem::class
            ])
            ;
    }
}