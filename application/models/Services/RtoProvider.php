<?php
namespace Services;

class RtoProvider extends \Dataservice_Service_ServiceAbstract
{   
    public function getAllRtoProviders()
    {
	return $this->_em->getRepository("Entities\Company\RtoProvider")->findBy(array(), array("name" => "ASC"));
    }
}