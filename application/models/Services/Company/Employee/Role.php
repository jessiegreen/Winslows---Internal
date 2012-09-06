<?php
namespace Services\Company\Employee;

class Role extends \Dataservice_Service_ServiceAbstract
{
    public function getAllRoles()
    {
	return $this->_em->getRepository("Entities\Company\Employee\Role")
		->findBy(array(), array("name" => "ASC"));
    }
}