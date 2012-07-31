<?php
namespace Services;

use Doctrine\ORM\EntityManager;

class ConfigurableProductOption {
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
	return new ConfigurableProductOption;
    }
    
    public function getAllConfigurableProductOptions(){
	return $this->_em->getRepository("Entities\ConfigurableProductOption")->findBy(array(), array("name" => "ASC"));
    }
    
    public function getAllConfigurableProductOptionsSortedByGroup(){
	return $this->_em->getRepository("Entities\ConfigurableProductOption")->findBy(array(), array("ConfigurableProductOptionGroup_id" => "ASC", "name" => "ASC"));
    }
}

?>
