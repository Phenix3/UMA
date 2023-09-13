<?php

declare(strict_types=1);

namespace App\Http\Grid;

use Prezent\Grid\BaseGridType;
use Prezent\Grid\Extension\Core\Type\StringType;
use Prezent\Grid\GridBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageGrid extends BaseGridType
{
    public function buildGrid(GridBuilder $builder, array $options = []): void
    {
        $builder
            ->addColumn('title', StringType::class, [
                'sortable' => true,
            ])
            ->addColumn('description', StringType::class, [
                'sortable' => false,
            ])
            ->addAction('edit', [
                'route' => $options['routePrefix'] . '_edit',
                'route_parameters' => [
                    'id' => '{id}',
                ],
            ])
            ->addAction('delete', [
                'route' => $options['routePrefix'] . '_delete',
                'route_parameters' => [
                    'id' => '{id}',
                ],
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
