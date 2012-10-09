<?php
namespace Services\Company\RtoProvider;

class Fee extends \Dataservice_Service_ServiceAbstract
{   
    public function getAllFees()
    {
	return $this->_em->getRepository("Entities\Company\RtoProvider\Fee\FeeAbstract")->findBy(array(), array("name" => "ASC"));
    }
}