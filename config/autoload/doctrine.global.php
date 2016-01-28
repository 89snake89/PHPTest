<?php
//Doctrine configuration globale
return array(
	'doctrine' => array(
		'connection' => array(
			'orm_another' => array(
				'doctrine_type_mappings' => array('enum' => 'string'),
				'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
				'params' => array(
				'host' => 'localhost', //Database HOST
				'port' => '3306', //Database PORT
				'dbname' => 'phptest-prontopro', //Database name
				)
			),
		)
	)
);