<?php
class Dataservice_Controller_Plugin_ACL extends Zend_Controller_Plugin_Abstract
{
    private $debug = false;
    
    public function preDispatch(Zend_Controller_Request_Abstract $request) 
    {
        $objAuth    = Zend_Auth::getInstance();
	$clearACL   = true;
	$front	    = \Zend_Controller_Front::getInstance();
	$bootstrap  = $front->getParam("bootstrap");
	/* @var $em \Doctrine\ORM\EntityManager */
	$em	    = $bootstrap->getResource('entityManager');
 
	// initially treat the user as a guest so we can determine if the current
	// resource is accessible by guest users
	$role = 'Guest';
 
	// if its not accessible then we need to check for a user login
	// if the user is logged in then we check if the role of the logged
	// in user has the credentials to access the current resource
 
        try 
	{
	    if($objAuth->hasIdentity()) 
	    {
		if($this->debug)echo "Has Identity<br />";
 
		$Auth_Service	= \Services\Auth::factory();
		$sess		= new Zend_Session_Namespace('Dataservice');
		$allowed	= false;

		if($sess->clearACL)
		{
		    $clearACL = true;
		     unset($sess->clearACL);
		}

		$objAcl = Dataservice_ACL_Factory::get($em, $clearACL);
		
		$Person = $Auth_Service->getIdentityPerson();

		/* @var $Role \Entities\Company\Employee\Role */
		foreach($Person->getRoles() as $Role)
		{
		    if($this->debug)echo "**".$Role->getName()."**<br />";

		    if($objAcl->isAllowed($Role->getName(), $request->getModuleName() .'::' .$request->getControllerName() .'::' .$request->getActionName()))
			    $allowed = true;
		}
		 
		if(!$allowed)
		{
		    $request->setModuleName('default');
		    $request->setControllerName('error');
		    $request->setActionName('noauth');
		}
 
            } else 
	    {
		if($this->debug)echo "Does Not have Identity<br />";
		
	        $objAcl = Dataservice_ACL_Factory::get($em, $clearACL);
		
	        if(!$objAcl->isAllowed($role, $request->getModuleName() .'::' .$request->getControllerName() .'::' .$request->getActionName()))
		{
	            return Zend_Controller_Action_HelperBroker::getStaticHelper('redirector')->setGotoRoute(array("controller" => "login","action" => "index"));
	        }
	    }
        } 
	catch(Zend_Exception $e)
	{
	    if($this->debug)
	    {
		echo $e->getMessage().$e->getLine().$e->getFile();
		exit;
	    }
	    
            $request->setModuleName('default');
            $request->setControllerName('error');
            $request->setActionName('noresource');
        }
    }
}