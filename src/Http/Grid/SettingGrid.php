<?php

namespace App\Http\Grid;

use Prezent\Grid\BaseGridType;
use Prezent\Grid\GridBuilder;
use Prezent\Grid\Extension\Core\Type\StringType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingGrid extends BaseGridType
{

	public function buildGrid(GridBuilder $builder, array $options = []): void
	{
		$builder
			->addColumn('keyName', StringType::class, [
				'sortable' => true
			])
			->addColumn('value', StringType::class, [
				'sortable' => false
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