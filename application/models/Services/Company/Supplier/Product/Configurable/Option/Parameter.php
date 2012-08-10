<?php
namespace Services\Company\Supplier\Product\Configurable\Option;

class Parameter extends \Dataservice_Service_ServiceAbstract
{
    public function getAllParameters()
    {
	return $this->_em->getRepository("Entities\Company\Supplier\Product\Configurable\Option\Parameter")
		->findBy(array(), array("name" => "ASC"));
    }
    
    public function getAllParametersSortedByOption()
    {
	return $this->_em->getRepository("Entities\Company\Supplier\Product\Configurable\Option\Parameter")->
		findBy(array(), array("Option_id" => "ASC", "name" => "ASC"));
    }
}

?>
