<?php
namespace Services\Company\Supplier\Product\Configurable\Option;

class Category extends \Dataservice_Service_ServiceAbstract
{    
    public function getAllCategories()
    {
	return $this->_em->getRepository("Entities\Company\Supplier\Product\Configurable\Option\Category")
		->findBy(array(), array("order" => "ASC", "name" => "ASC"));
    }
}