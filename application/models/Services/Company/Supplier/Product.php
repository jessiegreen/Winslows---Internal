<?php
namespace Services\Company\Supplier;

class Product 
{
    public function getAllProducts()
    {
	return $this->_em->getRepository("Entities\Company\Supplier\Product")
		->findBy(array(), array("name" => "ASC"));
    }
}

?>
