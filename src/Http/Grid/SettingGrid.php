<?php

namespace App\Http\Grid;

use Prezent\Grid\BaseGridType;
use Prezent\Grid\GridBuilder;
use Prezent\Grid\Extension\Core\Type\StringType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingGrid extends BaseGridType
{

	public function buildGrid(GridBuilder $builder, array $options = [])
	{
		$builder
			->addColumn('keyName', StringType::class, [
				'sortable' => true
			])
			->addAction('delete', [
				'route' => $options['routePrefix'] . '_delete',
				'route_parameters' => [
					'keyName' => '{keyName}'
				]
			])
			;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver
			->setRequired('routePrefix')
			->setAllowedTypes('routePrefix', 'string')
			;
	}

}