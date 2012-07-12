<?php
namespace Services\Auth;

class Auth 
{
    /* @var \Doctrine\ORM\EntityManager $_em */
    private $_em;
    
    public function __construct() {
	$front	    = \Zend_Controller_Front::getInstance();
	$bootstrap  = $front->getParam("bootstrap");

	$this->_em  = $bootstrap->getResource('entityManager');
    }
    
    public function getIdentity(){
	/* @var $objAuth \Zend_Auth */
	$objAuth    = \Zend_Auth::getInstance();
	return $objAuth->getIdentity();
    }
    
    /**
     *
     * @return \Entities\Webaccount 
     */
    public function getIdentityWebAccount(){
	$IdentityWebAccount = $this->getIdentity();
	$this->_em->clear();	
	$WebAccount	    = $this->_em->find("Entities\Webaccount", $IdentityWebAccount->getId());
	return $WebAccount;
    }
}

?>
