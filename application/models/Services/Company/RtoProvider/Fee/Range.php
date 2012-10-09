<?php
namespace Services\Company\RtoProvider\Fee;

class Range extends \Dataservice_Service_ServiceAbstract
{   
    public function getAllRanges()
    {
	return $this->_em->getRepository("Entities\Company\RtoProvider\Fee\Range")->findBy(array(), array("name" => "ASC"));
    }
}