<?php
namespace Services;

class Auth 
{
    /* @var \Doctrine\ORM\EntityManager $_em */
    private $_em;
    
    public function __construct() {
	$front	    = \Zend_Controller_Front::getInstance();
	$bootstrap  = $front->getParam("bootstrap");

	$this->_em  = $bootstrap->getResource('entityManager');
    }
    
    public static function factory() {
	return new Auth();
    }
    
    public function getIdentity(){
	/* @var $objAuth \Zend_Auth */
	$objAuth    = \Zend_Auth::getInstance();
	return $objAuth->getIdentity();
    }
    
    /**
     *
     * @return \Entities\Company\Website\Account 
     */
    public function getIdentityAccount(){
	$IdentityAccount = $this->getIdentity();
	$Account	    = $this->_em->find("Entities\Company\Website\Account", $IdentityAccount->getId());
	return $Account;
    }
    
    public function getIdentityPerson(){
	return $this->getIdentityAccount()->getPerson();
    }
    
    public function getIdentityCompany(){
	return $this->getIdentity;## Create EmployeeAccount and set Account as BaseClass...Roles only for Employee Web Account?
    }
}

?>
