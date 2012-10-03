<?php
namespace Services\Company\Dealer;

class Location extends \Dataservice_Service_ServiceAbstract
{
    public function getAllLocations()
    {
	return $this->_em->getRepository("Entities\Company\Dealer\Location")->findBy(array(), array("name" => "ASC"));
    }
}