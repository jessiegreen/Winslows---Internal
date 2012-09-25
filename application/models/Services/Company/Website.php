<?php
namespace Services\Company;

class Website extends \Dataservice_Service_ServiceAbstract
{
    public function getAllWebsites()
    {
	return $this->_em->getRepository("Entities\Company\Website")->findBy(array(), array("name" => "ASC"));
    }
}