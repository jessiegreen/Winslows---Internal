<?php
namespace Services\Company;

class Supplier extends \Dataservice_Service_ServiceAbstract
{
    public function getAllSuppliers()
    {
	return $this->_em->getRepository("Entities\Company\Supplier")->findBy(array(), array("name" => "ASC"));
    }
}