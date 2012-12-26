<?php
namespace Services;

class ACL extends \Dataservice_Service_ServiceAbstract
{    
    /**
     * @param mixed $url 
     *	string=module::controller::action 
     *	array=array("module"=>module,"controller"=>controller,"action"=>action)
     * @return boolean 
     */
    public function isUserAllowed($url)
    {
	if(is_string($url))
	{
	    $array = explode("::", $url);
	    
	    if(count($array) != 3)throw new \Exception("String passed to isUserAllowed is invalid");
	    
	    $module	= $array[0];
	    $controller = $array[1];
	    $action	= $array[2];
	}
	elseif(is_array ($url))
	{
	    if(!isset($url['module']) || !isset($url["controller"]) || !isset($url['action']))
	    {
		throw new \Exception("Array passed to isUserAllowed is invalid");
	    }
	    
	    $module	= $url['module'];
	    $controller = $url['controller'];
	    $action	= $url['action'];
	}
	else throw new Exception("param sent to isUserAllowed is invalid");
	
	$Person	    = \Services\Auth::factory()->getIdentityPerson();
	$objAcl	    = \Dataservice_ACL_Factory::get($this->_em);
	
	if($Person)
	{
	    /* @var $Role \Entities\Company\Employee\Role */
	    foreach($Person->getRoles() as $Role)
	    {
		if($objAcl->isAllowed($Role->getName(), $module .'::' .$controller .'::' .$action))
		    return true;
	    }
	}
	return false;
    }
}