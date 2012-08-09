<?php
namespace Services;

use Doctrine\ORM\EntityManager;

class Location {
    /**
     *
     * @var EntityManager $_em 
     */
    private $_em;

    public function __construct()
    {
        $front			= \Zend_Controller_Front::getInstance();
	$bootstrap		= $front->getParam("bootstrap");
	$this->_em		= $bootstrap->getResource('entityManager');
    }
    
    public static function factory() {
	return new Location;
    }
    
    public function getLocations(){
	return $this->_em->getRepository("Entities\Company\Location")->findAll();
    }
}

?>
