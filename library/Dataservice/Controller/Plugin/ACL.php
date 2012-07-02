<?php
class Dataservice_Controller_Plugin_ACL extends Zend_Controller_Plugin_Abstract {
 
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $objAuth = Zend_Auth::getInstance();
	$clearACL = false;
	$front			= \Zend_Controller_Front::getInstance();
	$bootstrap		= $front->getParam("bootstrap");
	$em		= $bootstrap->getResource('entityManager');
 
	// initially treat the user as a guest so we can determine if the current
	// resource is accessible by guest users
	$role = 'guest';
 
	// if its not accessible then we need to check for a user login
	// if the user is logged in then we check if the role of the logged
	// in user has the credentials to access the current resource
 
        try {
	    if($objAuth->hasIdentity()) {
		/* @var $Webaccount \Entities\Webaccount */
	        $Webaccount = $objAuth->getIdentity();
 
	         $sess = new Zend_Session_Namespace('Dataservice');
	         if($sess->clearACL) {
	             $clearACL = true;
	              unset($sess->clearACL);
	         }
 
                 $objAcl = Dataservice_ACL_Factory::get($objAuth,$em,$clearACL);
 
		 $allowed = false;
		 
		 /* @var $Role \Entities\Role */
		 echo $Webaccount->getPerson()->getId()."Roles:".count($Webaccount->getRoles());
		 foreach($Webaccount->getRoles() as $Role){
		     echo $Role->getName()."<br />";
		     if($objAcl->isAllowed($Role->getName(), $request->getModuleName() .'::' .$request->getControllerName() .'::' .$request->getActionName()))
			     $allowed = true;
		 }
	         if(!$allowed) {
	             $request->setModuleName('default');
        	     $request->setControllerName('error');
        	     $request->setActionName('noauth');
	         }
 
            } else {
	        $objAcl = DJC_ACL_Factory::get($objAuth,$clearACL);
	        if(!$objAcl->isAllowed($role, $request->getModuleName() .'::' .$request->getControllerName() .'::' .$request->getActionName())) {
	            return Zend_Controller_Action_HelperBroker::getStaticHelper('redirector')->setGotoRoute(array(),"login");
	        }
	    }
        } catch(Zend_Exception $e) {
            $request->setModuleName('default');
            $request->setControllerName('error');
            $request->setActionName('noresource');
        }
    }
}