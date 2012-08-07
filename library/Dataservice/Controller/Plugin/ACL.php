<?php
class Dataservice_Controller_Plugin_ACL extends Zend_Controller_Plugin_Abstract {
    private $debug = false;
    
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
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
 
        try {
	    if($objAuth->hasIdentity()) {
		if($this->debug)echo "Has Identity<br />";
		/* @var $Account \Entities\Company\Website\Account */
	        $Account = $objAuth->getIdentity();
 
	         $sess = new Zend_Session_Namespace('Dataservice');
	         if($sess->clearACL) {
	             $clearACL = true;
	              unset($sess->clearACL);
	         }
		 if($this->debug)echo "<br /><u>Begin Factory::get()</u><br />";
                 $objAcl = Dataservice_ACL_Factory::get($em, $clearACL);
		 if($this->debug)echo "<br /><u>End Factory::get()</u><br />";
		 
		 $allowed = false;
		 
		 #--After hours of fighting I realized thanks to a podcast that I had to clear the $em as the 
		 #--caching was screwing this up
		 $Account_id = $Account->getId();
		 $em->clear();

		 $Account = $em->find("Entities\Company\Website\Account", $Account_id);
		 
		 /* @var $Role \Entities\Company\Website\Account\Role */
		 foreach($Account->getRoles() as $Role){
		     if($this->debug)echo "**".$Role->getName()."**<br />";
		     if($objAcl->isAllowed($Role->getName(), $request->getModuleName() .'::' .$request->getControllerName() .'::' .$request->getActionName()))
			     $allowed = true;
		 }
	         if(!$allowed) {
	             $request->setModuleName('default');
        	     $request->setControllerName('error');
        	     $request->setActionName('noauth');
	         }
 
            } else {
		if($this->debug)echo "Does Not have Identity<br />";
	        $objAcl = Dataservice_ACL_Factory::get($em, $clearACL);
	        if(!$objAcl->isAllowed($role, $request->getModuleName() .'::' .$request->getControllerName() .'::' .$request->getActionName())) {
	            return Zend_Controller_Action_HelperBroker::getStaticHelper('redirector')->setGotoRoute(array("controller" => "login","action" => "index"));
	        }
	    }
        } catch(Zend_Exception $e) {
	    if($this->debug){
		echo $e->getMessage().$e->getLine().$e->getFile();
		exit;
	    }
            $request->setModuleName('default');
            $request->setControllerName('error');
            $request->setActionName('noresource');
        }
    }
}