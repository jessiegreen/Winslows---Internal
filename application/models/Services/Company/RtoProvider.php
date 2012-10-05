<?php
namespace Services\Company;

class RtoProvider extends \Dataservice_Service_ServiceAbstract
{   
    public function getAllRtoProviders()
    {
	return $this->_em->getRepository("Entities\Company\RtoProvider")->findBy(array(), array("name" => "ASC"));
    }
    
    public function findByIndex($index)
    {
	return $this->_em->getRepository("Entities\Company\RtoProvider")->findOneBy(array("name_index" => $index));
    }
}