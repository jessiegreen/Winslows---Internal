<?php
namespace Services\Company;

class Dealer extends \Dataservice_Service_ServiceAbstract
{
    public function getAllDealers()
    {
	return $this->_em->getRepository("Entities\Company\Dealer")->findBy(array(), array("name" => "ASC"));
    }
}