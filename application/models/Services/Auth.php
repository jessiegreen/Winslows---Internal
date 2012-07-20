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
     * @return \Entities\WebAccount 
     */
    public function getIdentityWebAccount(){
	$IdentityWebAccount = $this->getIdentity();
	$WebAccount	    = $this->_em->find("Entities\WebAccount", $IdentityWebAccount->getId());
	return $WebAccount;
    }
    
    public function getIdentityPerson(){
	return $this->getIdentityWebAccount()->getPerson();
    }
    
    public function getIdentityCompany(){
	return $this->getIdentity;## Create EmployeeWebAccount and set WebAccount as BaseClass...Roles only for Employee Web Account?
    }
}

?>
