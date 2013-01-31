<?php
class Dataservice_Controller_Plugin_ACL extends Zend_Controller_Plugin_Abstract
{    
    /**
     * if its not accessible then we need to check for a user login
     * if the user is logged in then we check if the role of the logged
     * in user has the credentials to access the current resource
     * @param Zend_Controller_Request_Abstract $request
     * @return type
     * @throws Exception
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request) 
    {
	$front		= \Zend_Controller_Front::getInstance();
	$bootstrap	= $front->getParam("bootstrap");
	$Website	= Services\Company\Website::factory()->getCurrentWebsite();
	$objAcl		= Dataservice_ACL_Factory::get($Website);
        $objAuth	= Zend_Auth::getInstance();
	$allowed	= false;
	$error_temp	= false;
	
        try 
	{
	    if(!$objAuth->hasIdentity())
	    {		
		$GuestAccount = $Website->getGuestAccount();

		if($GuestAccount !== false)$objAuth->getStorage()->write($GuestAccount->getId());
	    }
	    
	    if(!$objAuth->hasIdentity())
		$this->_routeToLogin();

	    $Account = $Website->getCurrentUserAccount($objAuth);
	    
	    if(!$Account)
	    {
		$objAuth->clearIdentity();
		
		throw new Exception("No account for Auth Id!");
	    }
	    
	    try
	    {
		if($Account->isAllowedToAccessRequest($request, $objAcl))$allowed = true;
	    } 
	    catch (Exception $exc)
	    {
		$error_temp = true;
	    }	    
	    
	    if($error_temp)
	    {
		$request->setControllerName('error');
		$request->setActionName('noresource');
	    }
	    elseif(!$allowed)
	    {
		if($Account->isGuestAccount())$this->_routeToLogin();
		
		$request->setControllerName('error');
		$request->setActionName('noauth');
	    }
        } 
	catch(Zend_Exception $e)
	{
            $request->setControllerName('error');
            $request->setActionName('noresource');
        }
    }
    
    /**
     * @return void
     */
    private function _routeToLogin()
    {
	Zend_Controller_Action_HelperBroker::getStaticHelper('redirector')->goToUrl("/login");
    }
}