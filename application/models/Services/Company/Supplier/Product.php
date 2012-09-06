<?php
namespace Services\Company\Supplier;

class Product extends \Dataservice_Service_ServiceAbstract
{
    public function getAllProducts()
    {
	return $this->_em->getRepository("Entities\Company\Supplier\Product\ProductAbstract")
		->findBy(array(), array("name" => "ASC"));
    }
}