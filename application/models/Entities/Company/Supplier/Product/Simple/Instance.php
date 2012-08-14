<?php

namespace Entities\Company\Supplier\Product\Simple;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Simple\Instance") 
 * @Table(name="company_supplier_product_simple_instances") 
 */
class Instance extends \Entities\Company\Supplier\Product\Instance\InstanceAbstract implements \Interfaces\Company\Supplier\Product\Instance\InstanceAbstract 
{    
    /**
     * @return \Entities\Company\Supplier\Product\Simple
     */
    public function getProduct()
    {
	return parent::getProduct();
    }
    
    public function getPrice() 
    {
	return $this->getProduct()->getPrice();
    }
}
