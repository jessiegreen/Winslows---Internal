<?php
namespace Services\Company\Location;

class Employee extends \Dataservice_Service_ServiceAbstract
{
    public function getEmployees()
    {
	return $this->_em->getRepository("Entities\Company\Location\Employee")
		->findBy(array(), array("first_name" => "ASC"));
    }
}

?>
