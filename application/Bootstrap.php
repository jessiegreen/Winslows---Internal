<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initConfig()
    {
	$config = new Zend_Config($this->getOptions());
	Zend_Registry::set('config', $config);
    }
    
    protected function _initBootstrap()
    {
	date_default_timezone_set ("America/Mexico_City");
	#--Set View Environment
	$this->bootstrap('view');
        $view = $this->getResource('view');

        //$view->doctype('XHTML1_STRICT');
	$view->headTitle()->setSeparator (' ~ ');
	
	switch ($_SERVER['HTTP_HOST'])
	{
	    case "www.winslowsinc.local":
		$module = "winslows";
		$view->headTitle('DEV - Winslow\'s Inc.');
		break;
	    case "www.winslowsinc.com":
		$module = "winslows";
		$view->headTitle('Winslow\'s Inc.');
		break;
	    case "www.texwincarports.local":
		$module = "texwin";
		$view->headTitle('DEV - Texwin Carports');
		break;
	    case "www.texwincarports.com":
		$module = "texwin";
		$view->headTitle('Texwin Carports');
		break;
	    case "company.winslowsinc.local":
		$module = "company";
		$view->headTitle('DEV - Winslow\'s Inc. Company');
		break;
	    case "company.winslowsinc.com":
		$module = "company";		
		$view->headTitle('Winslow\'s Inc. Company');
		break;
	    default:
		throw new Exception("Error!!");
		break;
	}
	
	$router		= $this->bootstrap('frontController')
					->getResource('frontController')
					->getRouter();
	
	
	$hostnameRoute	= new Zend_Controller_Router_Route_Hostname(
					    $_SERVER['HTTP_HOST'], 
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

	#--Base Url
	$baseUrl = "";
	define('BASE_URL', $baseUrl);

	#--Public Path
	$public_path = realpath(APPLICATION_PATH."/../public");
	define('PUBLIC_PATH', $public_path);
	
	#-- Site Name
	define('SITE_NAME', 'Dataservice');
	
	require_once APPLICATION_PATH."/classes/HTML.php";
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
    
    protected function _initPlugins()
    {
	#--Register Front controller Plugins
	$front = Zend_Controller_Front::getInstance();
	$front->registerPlugin(new Dataservice_Controller_Plugin_ACL(), 1);
	
	#--Register Controller Action Helpers
	Zend_Controller_Action_HelperBroker::addHelper(new Dataservice_Controller_Action_Helper_History());
    }
    
    protected function _initLayoutHelper()  
    {  
	$this->bootstrap('frontController');  
	$layout = Zend_Controller_Action_HelperBroker::addHelper(  
	    new Dataservice_Controller_Action_Helper_SetLayoutPath(APPLICATION_PATH));  
    }  
}

