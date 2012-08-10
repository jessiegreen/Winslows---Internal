<?php
namespace Services\Company\Supplier\Product\Configurable;

class Option extends \Dataservice_Service_ServiceAbstract
{
    public function getAllOptions()
    {
	return $this->_em->getRepository("Entities\Company\Supplier\Product\Configurable\Option")
		->findBy(array(), array("name" => "ASC"));
    }
}