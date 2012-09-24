<?php
namespace Services;

class Auth extends \Dataservice_Service_ServiceAbstract
{
    public function getIdentity()
    {
	/* @var $objAuth \Zend_Auth */
	$objAuth    = \Zend_Auth::getInstance();
	return $objAuth->getIdentity();
    }

    public function getIdentityAccount()
    {
	$account_id	= $this->getIdentity();
	
	if(!$account_id)return false;
	    
	$Account	= $this->_em->find("Entities\Website\Account\AccountAbstract", $account_id);
	
	return $Account;
    }
    
    public function getIdentityPerson()
    {
	$Account = $this->getIdentityAccount();
	
	if($Account)
	{
	    switch ($Account->getDescriminator())
	    {
		case "Employee":
		    return $Account->getEmployee();
		break;
		case "Guest":
		    return $Account->getGuest();
		break;
		default:
		    return null;
	    }
	}
    }
    
    public function getIdentityCompany()
    {
	return $this->getIdentity;## Create EmployeeAccount and set Account as BaseClass...Roles only for Employee Web Account?
    }
}