<?php

namespace App\Http\Grid\Slider;

use Prezent\Grid\BaseGridType;
use Prezent\Grid\GridBuilder;
use Prezent\Grid\Extension\Core\Type\StringType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class SliderGrid extends BaseGridType
{
    public function __construct(private UrlGeneratorInterface $urlGenerator){}
    
    public function buildGrid(GridBuilder $builder, array $options = []): void
    {
        $builder
            ->addColumn('id', StringType::class)
            ->addColumn('name', StringType::class)
            ->addColumn('slug', StringType::class)
            ->addAction('items', [
                'label' => 'ui.buttons.items',
                'route' => $options['routePrefix'] . '_items',
				'route_parameters' => [
					'id' => '{id}'
				]
                ])
            ->addAction('edit', [
                'route' => $options['routePrefix'] . '_edit',
				'route_parameters' => [
					'id' => '{id}'
				]
            ])
            ->addAction('delete', [
                'route' => $options['routePrefix'] . '_delete',
				'route_parameters' => [
					'id' => '{id}'
				]
            ])
            
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
			->setRequired('routePrefix')
			->setAllowedTypes('routePrefix', 'string')
            /*->setRequired('itemsRoute')
			->setAllowedTypes('itemsRoute', 'string')*/
			;
    }
}