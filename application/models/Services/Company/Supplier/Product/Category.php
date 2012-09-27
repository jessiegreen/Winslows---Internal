<?php
namespace Services\Company\Supplier\Product;

class Category extends \Dataservice_Service_ServiceAbstract
{
    public function getAllCategories()
    {
	return $this->_em->getRepository("Entities\Company\Supplier\Product\Category")->findBy(array(), array("name" => "ASC"));
    }
}