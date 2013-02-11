<?php
namespace Services;

class Auth extends \Dataservice_Service_ServiceAbstract
{
    /**
     * @return Auth
     */
    public function factory()
    {
	return parent::factory();
    }
    
    public function getIdentity()
    {
	/* @var $objAuth \Zend_Auth */
	$objAuth    = \Zend_Auth::getInstance();
	
	return $objAuth->getIdentity();
    }
}