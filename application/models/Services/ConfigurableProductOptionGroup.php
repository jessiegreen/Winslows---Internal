<?php
namespace Services;

use Doctrine\ORM\EntityManager;

class ConfigurableProductOptionGroup {
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
	return new ConfigurableProductOptionGroup;
    }
    
    public function getAllConfigurableProductOptionGroups(){
	return $this->_em->getRepository("Entities\ConfigurableProductOptionGroup")->findBy(array(), array("name" => "ASC"));
    }
}

?>
