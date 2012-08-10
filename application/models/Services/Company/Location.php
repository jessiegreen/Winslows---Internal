<?php
namespace Services\Company;

class Location extends \Dataservice_Service_ServiceAbstract
{
    public function getLocations()
    {
	return $this->_em->getRepository("Entities\Company\Location")->findAll();
    }
}