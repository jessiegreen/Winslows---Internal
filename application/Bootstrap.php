<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    
    /**
    *
    *
    *
    *
    */
    protected function _initConfig()
    {

	$config = new Zend_Config($this->getOptions());
	Zend_Registry::set('config', $config);

    }
    
    protected function _initBootstrap()
    {
	#--Set View Environment
	$this->bootstrap('view');
        $view = $this->getResource('view');

        //$view->doctype('XHTML1_STRICT');
	$view->headTitle()->setSeparator (' ~ ');
	$view->headTitle('Winslowsinc Internal');

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

    /**
    *
    *
    *
    *
    */
    protected function _initDoctrine() 
    {
	require_once('Doctrine/Common/ClassLoader.php');

	$autoloader = Zend_Loader_Autoloader::getInstance();
	$classLoader = new \Doctrine\Common\ClassLoader('Entities',
	realpath(Zend_Registry::get('config')->resources->entityManager->connection->entities), 'loadClass');

	$autoloader->pushAutoloader(array($classLoader, 'loadClass'), 'Entities');

	$classLoader = new \Doctrine\Common\ClassLoader('Repositories',
	realpath(Zend_Registry::get('config')->resources->entityManager->connection->entities), 'loadClass');

	$autoloader->pushAutoloader(array($classLoader, 'loadClass'), 'Repositories');  
	
	$classLoader = new \Doctrine\Common\ClassLoader('Services',
	realpath(Zend_Registry::get('config')->resources->entityManager->connection->entities), 'loadClass');

	$autoloader->pushAutoloader(array($classLoader, 'loadClass'), 'Services');
	
	$classLoader = new \Doctrine\Common\ClassLoader('Classes',
	realpath(Zend_Registry::get('config')->resources->entityManager->connection->classes), 'loadClass');

	$autoloader->pushAutoloader(array($classLoader, 'loadClass'), 'Classes');
    }
  
    protected function _initAutoLoad() 
    {
	$autoLoader = Zend_Loader_Autoloader::getInstance();

	$resourceLoader = new Zend_Loader_Autoloader_Resource(array(
	    'basePath' => APPLICATION_PATH,
	    'namespace' => '',
	));


	$resourceLoader->addResourceType('form', 'forms/', 'Form_');
	$resourceLoader->addResourceType('service', 'models/Services/', 'Service_');
	$resourceLoader->addResourceType('class', 'classes/', 'Classes_');

	$autoLoader->pushAutoloader($resourceLoader);
    }
    
    protected function _initPlugins() {
	$front = Zend_Controller_Front::getInstance();
	$front->registerPlugin(new Dataservice_Controller_Plugin_ACL(), 1);
    }
  
}

