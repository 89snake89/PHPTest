<?php
return array(
		//Definition of module's controllers
		'controllers' => array(
				'invokables' => array(
						'Product\Controller\Product' => 'Product\Controller\ProductController',
				),
		),
		// Definition of Module's routes
		'router' => array(
				'routes' => array(
						'product' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/product[/][:id][/:action]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Product\Controller\Product',
												'action'     => 'index',
										),
								),
						),
				),
		),
		//Doctrine configuration
		'doctrine' => array(
			'driver' => array(
				__NAMESPACE__ . '_entities' => array(
						'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
						'cache' => 'array',
						'paths' => array(
								__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
						),
				),
				 
				// Lasciamo invariata questa chiave (orm_default), è utilizzata dalla CLI
				'orm_another' => array(
						'class'   => 'Doctrine\ORM\Mapping\Driver\DriverChain',
						'drivers' => array(
								__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_entities'
						)
				)
			),
			 
			'configuration' => array(
					'orm_another' =>  array(
							'metadata_cache'    => 'array',
							'query_cache'       => 'array',
							'result_cache'      => 'array',
							'driver'            => 'orm_another',
							'generate_proxies'  => true,
							'proxy_dir'         => 'data/DoctrineORMModule/Proxy',
							'proxy_namespace'   => 'DoctrineORMModule\Proxy',
							'filters'           => array()
					),
			),
			 
			'entitymanager' => array(
					'orm_another' => array(
							'connection'    => 'orm_another',
							'configuration' => 'orm_another'
					)
			),
			 
			'eventmanager' => array(
					'orm_another' => array()
			),
			 
			'sql_logger_collector' => array(
					'orm_another' => array()
			),
			 
			'entity_resolver' => array(
					'orm_another' => array()
			),
		),
		//Definition view managers
		'view_manager' => array(
				'template_path_stack' => array(
						'product' => __DIR__ . '/../view',
				),
		),
);