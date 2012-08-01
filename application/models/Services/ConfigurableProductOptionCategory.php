<?php
namespace Services;

use Doctrine\ORM\EntityManager;

class ConfigurableProductOptionCategory {
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
	return new ConfigurableProductOptionCategory;
    }
    
    public function getAllConfigurableProductOptionCategories(){
	return $this->_em->getRepository("Entities\ConfigurableProductOptionCategory")->findBy(array(), array("order" => "ASC", "name" => "ASC"));
    }
}

?>
