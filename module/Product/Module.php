<?php
namespace Product;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\EventManager\EventInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Symfony\Component\Console\Helper\DialogHelper;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;

class Module implements AutoloaderProviderInterface, ControllerProviderInterface,
BootstrapListenerInterface, ServiceProviderInterface,
ConfigProviderInterface, InitProviderInterface
{
	public function init(ModuleManagerInterface $manager){
		$events = $manager->getEventManager();
		// Initialize logger collector once the profiler is initialized itself
		$events->attach('profiler_init', function() use ($manager) {
			$manager->getEvent()->getParam('ServiceManager')
			->get('doctrine.sql_logger_collector.orm_another'); // moduificare nome
		});
	}

	public function onBootstrap(EventInterface $e){
		$app = $e->getTarget();
		$events = $app->getEventManager()->getSharedManager();
		// Attach to helper set event and load the entity manager helper.
		$events->attach('doctrine', 'loadCli.post', function (EventInterface $e){
			$cli = $e->getTarget();
			ConsoleRunner::addCommands($cli);
				
			if(class_exists('Doctrine\\DBAL\\Migrations\\Versions')){
				$cli->add(array(
						new DiffCommand(),
						new ExecuteCommand(),
						new GenerateCommand(),
						new MigrateCommand(),
						new StatusCommand(),
						new VersionCommand(),
				));
			}
				
			$sm = $e->getParam('ServiceManager');
			$em = $sm->get('doctrine.entitymanager.orm_another');
				
			$helperSet = $cli->getHelperSet();
			$helperSet->set(new DialogHelper(), 'dialog');
			$helperSet->set(new ConnectionHelper($em->getConnection()), 'db');
			$helperSet->set(new EntityManagerHelper($em), 'em');
		});
	}

	public function getControllerConfig(){
		return include __DIR__ . '/config/controllers.config.php';
	}
	
	public function getAutoloaderConfig(){
		return array(
				'Zend\Loader\ClassMapAutoloader' => array(
						__DIR__ . '/autoload_classmap.php',
				),
				'Zend\Loader\StandardAutoloader' => array(
						'namespaces' => array(
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
						),
				),
		);
	}
	
	public function getConfig(){
		return include __DIR__ . '/config/module.config.php';
	}

	public function getServiceConfig(){
		return include __DIR__ . '/config/service.config.php';
	}

}