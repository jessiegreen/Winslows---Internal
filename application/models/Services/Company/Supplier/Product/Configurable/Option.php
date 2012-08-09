<?php
namespace Services\Company\Supplier\Product\Configurable;

class Option 
{
    public function getAllOptions()
    {
	return $this->_em->getRepository("Entities\Company\Supplier\Product\Configurable\Option")
		->findBy(array(), array("name" => "ASC"));
    }
}