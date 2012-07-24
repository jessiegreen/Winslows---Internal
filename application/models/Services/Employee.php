<?php
namespace Services;

use Doctrine\ORM\EntityManager;

class Employee {
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
    
    public static function factory(){
	return new Employee;
    }
    
    public function getEmployees(){
	return $this->_em->getRepository("Entities\Employee")->findBy(array(), array("first_name" => "ASC"));
    }
}

?>
