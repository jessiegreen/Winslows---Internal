<?php
namespace Services\Company\Supplier;

class Product extends \Dataservice_Service_ServiceAbstract
{
    public function getAllProducts()
    {
	return $this->_em->getRepository("Entities\Company\Supplier\Product\ProductAbstract")
		->findBy(array(), array("name" => "ASC"));
    }
    
    /**
     * @param string $id
     * @return \Entities\Company\Supplier\Product\ProductAbstract
     */
    public function find($id)
    {
	return $this->_em->getRepository("Entities\Company\Supplier\Product\ProductAbstract")->find($id);
    }
}