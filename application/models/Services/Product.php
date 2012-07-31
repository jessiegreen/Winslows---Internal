<?php
namespace Services;

use Doctrine\ORM\EntityManager;

class Product {
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
	return new Product;
    }
    
    public function getAllProducts(){
	return $this->_em->getRepository("Entities\Product")->findBy(array(), array("name" => "ASC"));
    }
}

?>
