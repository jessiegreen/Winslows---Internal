<?php
namespace Services;

class ACL {
    /* @var \Doctrine\ORM\EntityManager $_em */
    private $_em;
    
    public function __construct() {
	$front	    = \Zend_Controller_Front::getInstance();
	$bootstrap  = $front->getParam("bootstrap");

	$this->_em  = $bootstrap->getResource('entityManager');
    }
    
    public static function factory() {
	return new ACL;
    }
    
    /**
     *
     * @param mixed $url 
     *	string=module::controller::view 
     *	array=array("module"=>module,"controller"=>controller,"view"=>view)
     * @return boolean 
     */
    public function isUserAllowed($url){
	if(is_string($url))
	{
	    $array = explode("::", $url);
	    
	    if(count($array) != 3)throw new \Exception("String passed to isUserAllowed is invalid");
	    
	    $module	= $array[0];
	    $controller = $array[1];
	    $action	= $array[2];
	}
	elseif(is_array ($url)){
	    if(!isset($url['module']) || !isset($url["controller"]) || !isset($url['action'])){
		throw new \Exception("Array passed to isUserAllowed is invalid");
	    }
	    $module	= $url['module'];
	    $controller = $url['controller'];
	    $action	= $url['action'];
	}
	else throw new Exception("param sent to isUserAllowed is invalid");
	
	$Account	= \Services\Auth::factory()->getIdentityAccount();
	$objAcl		= \Dataservice_ACL_Factory::get($this->_em);
	
	/* @var $Role \Entities\Company\Employee\Role */
	foreach($Account->getRoles() as $Role)
	{
	    if($objAcl->isAllowed($Role->getName(), $module .'::' .$controller .'::' .$action))
		return true;
	}
	return false;
    }
}