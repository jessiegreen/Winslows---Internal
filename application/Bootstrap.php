<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initSetPHPOptions()
    {
	date_default_timezone_set ("America/Mexico_City");	
    }
    
    protected function _initConfig()
    {
	$config = new Zend_Config($this->getOptions());
	
	Zend_Registry::set('config', $config);
    }
    
    protected function _initViewSetup()
    {
	$this->bootstrap('view');
	
        $view = $this->getResource('view');

	$view->headTitle()->setSeparator (' ~ ');
	
	$env_string = getenv('APPLICATION_ENV') == "development" ? " DEV" : "";
	
	$view->headTitle()->prepend(ucfirst(getenv('WEBSITE_NAME_INDEX')).$env_string);
    }

    protected function _initBootstrap()
    {	
	#--set host as doctrine to be able to run scripts from command line where there is no host. Need to revisit 
	$host_name  = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : "doctrine";
	$name_index = getenv('WEBSITE_NAME_INDEX');
	
	$module		= $name_index;
	$router		= $this->bootstrap('frontController')
					->getResource('frontController')
					->getRouter();
	
	
	$hostnameRoute	= new Zend_Controller_Router_Route_Hostname(
					    $host_name, 
					    array('module' => $module)
					);
	$router
	    ->addRoute(
		    $module, 
		    $hostnameRoute->chain(
			    new Zend_Controller_Router_Route(
				    ':controller/:action/*', 
				    array('controller'=>'index', 
					'action'=>'index'
				    )
			    )
		    )
	    );
    }
    
    protected function _initDefineConstants()
    {
	define ("WEBSITE_NAME_INDEX", getenv('WEBSITE_NAME_INDEX'));
	
	define('BASE_URL', "");
	
	define('PUBLIC_PATH', realpath(APPLICATION_PATH."/../public"));
    }

    protected function _initDoctrine() 
    {
	require_once('Doctrine/Common/ClassLoader.php');
	
	$EntityManagerConfigs = Zend_Registry::get('config')->resources->entityManager->connection;

	$autoloader	= Zend_Loader_Autoloader::getInstance();
	#--Entities
	$classLoader	= new \Doctrine\Common\ClassLoader('Entities', realpath($EntityManagerConfigs->entities), 'loadClass');
	$autoloader->pushAutoloader(array($classLoader, 'loadClass'), 'Entities');
	#--Repositories
	$classLoader	= new \Doctrine\Common\ClassLoader('Repositories', realpath($EntityManagerConfigs->entities), 'loadClass');
	$autoloader->pushAutoloader(array($classLoader, 'loadClass'), 'Repositories');  
	#--Services
	$classLoader	= new \Doctrine\Common\ClassLoader('Services', realpath($EntityManagerConfigs->entities), 'loadClass');
	$autoloader->pushAutoloader(array($classLoader, 'loadClass'), 'Services');
	#--Interfaces
	$classLoader	= new \Doctrine\Common\ClassLoader('Interfaces', realpath($EntityManagerConfigs->entities), 'loadClass');
	$autoloader->pushAutoloader(array($classLoader, 'loadClass'), 'Interfaces');
	#--Forms
	$classLoader	= new \Doctrine\Common\ClassLoader('Forms', realpath($EntityManagerConfigs->forms->location), 'loadClass');
	$autoloader->pushAutoloader(array($classLoader, 'loadClass'), 'Forms');
	#--Classes
	$classLoader = new \Doctrine\Common\ClassLoader('Classes', realpath($EntityManagerConfigs->classes), 'loadClass');
	$autoloader->pushAutoloader(array($classLoader, 'loadClass'), 'Classes');
    }
  
    protected function _initAutoLoad() 
    {
	$autoLoader = Zend_Loader_Autoloader::getInstance();

	$resourceLoader = new Zend_Loader_Autoloader_Resource(array(
	    'basePath' => APPLICATION_PATH,
	    'namespace' => '',
	));

	$autoLoader->pushAutoloader($resourceLoader);
    }
    
    protected function _initControllerActionHelpers()  
    {  
	$this->bootstrap('frontController');
	
	#--Layout Path Helper
	$layout = Zend_Controller_Action_HelperBroker::addHelper(  
	    new Dataservice_Controller_Action_Helper_SetLayoutPath(APPLICATION_PATH)
	);  
	#--History Helper
	Zend_Controller_Action_HelperBroker::addHelper(new Dataservice_Controller_Action_Helper_History());
    } 
    
    protected function _initControllerPlugins()
    {
	#--Register Front controller Plugins
	$front = Zend_Controller_Front::getInstance();
	$front->throwExceptions(true);

	$front->registerPlugin(new Dataservice_Controller_Plugin_ACL(), 1);
    } 
}

