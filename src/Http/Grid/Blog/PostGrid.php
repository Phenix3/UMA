<?php
namespace App\Http\Grid\Blog;

use Prezent\Grid\BaseGridType;
use Prezent\Grid\Extension\Core\Type\StringType;
use Prezent\Grid\GridBuilder;
use Prezent\Grid\GridView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostGrid extends BaseGridType
{
	public function buildGrid(GridBuilder $builder, array $options = [])
	{
		$builder
			->addColumn('id', StringType::class, [
				'sortable' => true
			])
			->addColumn('title', StringType::class)
			->addAction('edit', [
				'route' => $options['routePrefix'].'_edit',
				'route_parameters' => [
					'id' => '{id}'
				]
			])
			->addAction('delete', [
				'route' => $options['routePrefix'].'_delete',
				'route_parameters' => [
					'id' => '{id}'
				],
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