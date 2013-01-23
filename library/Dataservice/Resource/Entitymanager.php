<?php
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\SimpleAnnotationReader;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Annotations\AnnotationRegistry;
/**
 * This is a Zend Framework resource plugin. It is responsible for making
 * Doctrine 2 available to the application. See this page for more information about
 * the purpose of an entity manager:
 * http://www.doctrine-project.org/docs/orm/2.0/en/reference/working-with-objects.html
 *
 */
class Dataservice_Resource_Entitymanager extends Zend_Application_Resource_ResourceAbstract
{
    public function init()
    {
	// Custom resource plugins inherit this sweet getOptions() method which will retrieve
	// configuration settings from the application.ini file
	$config	    = new Zend_Config($this->getOptions());
	$configEm   = new \Doctrine\ORM\Configuration;
	$cache	    = new \Doctrine\Common\Cache\ArrayCache;
	
//	\Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace("Dataservice", APPLICATION_PATH."/../library/Dataservice/Annotations");
	AnnotationRegistry::registerFile(APPLICATION_PATH."/../library/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php");
	AnnotationRegistry::registerFile(APPLICATION_PATH."/../library/Dataservice/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php");
	AnnotationRegistry::registerAutoloadNamespace("Doctrine\ORM\Mapping");
	AnnotationRegistry::registerAutoloadNamespace("Dataservice\Doctrine\ORM\Mapping");
//	$driverImpl = $configEm->newDefaultAnnotationDriver(
//			    $config->connection->entities
//			);
	$reader	    = new SimpleAnnotationReader();
	
	$reader->addNamespace('Doctrine\ORM\Mapping');
	$reader->addNamespace('Dataservice\Doctrine\ORM\Mapping');
	
	$reader	    = new \Doctrine\Common\Annotations\CachedReader($reader, new ArrayCache());
	$driverImpl = new AnnotationDriver($reader, $config->connection->entities);

	// Define the connection parameters
	$options = array(
	    'connection' => array(
		'driver'   => "{$config->connection->driver}",
		'host'     => "{$config->connection->host}",
		'dbname'   => "{$config->connection->dbname}",
		'user'     => "{$config->connection->user}",
		'password' => "{$config->connection->password}"
	    )
	);

	$configEm->setMetadataCacheImpl($cache);

	$configEm->setMetadataDriverImpl($driverImpl);

	// Configure proxies

	$configEm->setAutoGenerateProxyClasses(
	    $config->connection->proxies->generate
	);      

	$configEm->setProxyNamespace($config->connection->proxies->ns);      

	$configEm->setProxyDir(
	    $config->connection->proxies->location
	);      

	// Configure cache

	$configEm->setQueryCacheImpl($cache);

	$em = \Doctrine\ORM\EntityManager::create($options['connection'], $configEm);
	
	Zend_Registry::set('em', $em);

	return $em;
    }
}