<?php
namespace Services\Company\Supplier\Product;

class Instance extends \Dataservice_Service_ServiceAbstract
{
    public function createInstanceFromProduct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	$type = $Product->getDescriminator();
	
	$class = "\Entities\Company\Supplier\Product\\$type\Instance";
	
	return new $class($Product);
    }
}