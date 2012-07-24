<?php
namespace Services;

use Doctrine\ORM\EntityManager;

class Company {
    /**
     *
     * @var EntityManager $_em 
     */
    private $_em;
    private $_company = "winslows";

    public function __construct()
    {
        $front			= \Zend_Controller_Front::getInstance();
	$bootstrap		= $front->getParam("bootstrap");
	$this->_em		= $bootstrap->getResource('entityManager');
    }
    
    public static function factory(){
	return new Company;
    }
    
    /**
     *
     * @return \Entities\Company 
     */
    public function getCurrentCompany(){
	return $this->_em->getRepository("Entities\Company")->findOneBy(array("name_index" => $this->_company));
    }
    
    public function getCompanies(){
	return $this->_em->getRepository("Entities\Company")->findBy(array(), array("name" => "ASC"));
    }
}

?>
