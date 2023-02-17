<?php

namespace App\Http\Grid\Slider;

use Prezent\Grid\BaseGridType;
use Prezent\Grid\GridBuilder;
use Prezent\Grid\Extension\Core\Type\StringType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SliderItemGrid extends BaseGridType
{
    public function buildGrid(GridBuilder $builder, array $options = []): void
    {
        $builder
            ->addColumn('id', StringType::class)
            ->addColumn('title', StringType::class)
            ->addColumn('link', StringType::class)
            ->addColumn('image', StringType::class)
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
			;
    }
}