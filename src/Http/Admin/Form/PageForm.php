<?php

namespace App\Http\Admin\Form;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Domain\Page\Entity\Page;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('translations', TranslationsType::class, [
                'fields' => [
                    'title' => [],
                    'description' => [],
                    'content' => [
                        'attr' => [
                            'is' => 'wysiwyg-editor',
                            'data-full-page' => true
                        ],
                    ],
                    'slug' => [
                        'disabled' => true,
                    ],
                ],
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver
            ->setDefaults([
                'data_class' => Page::class,
            ]);
    }
}
