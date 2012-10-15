<?php
namespace Services\Company;

class Employee extends \Dataservice_Service_ServiceAbstract
{
    public function getEmployees()
    {
	return $this->_em->getRepository("Entities\Company\Employee")
		->findBy(array(), array("first_name" => "ASC"));
    }
}