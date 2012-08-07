<?php

/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 */

class Service_Person {
    private $_em;
    
    public function __construct() {
	$front	    = Zend_Controller_Front::getInstance();
	$bootstrap  = $front->getParam("bootstrap");

	$this->_em  = $bootstrap->getResource('entityManager');
    }
    
    public function remove($person_id) {
	$person = $this->_em->getRepository('Entities\Person\PersonAbstract')
		    ->findOneById($person_id);
	$this->_em->remove($person);
	$this->_em->flush();
    }
}

?>
