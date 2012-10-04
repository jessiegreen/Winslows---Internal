<?php

namespace Entities\Company\Supplier\Product\Simple;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Simple\Instance") 
 * @Table(name="company_supplier_product_simple_instances") 
 */
class Instance extends \Entities\Company\Supplier\Product\Instance\InstanceAbstract implements \Interfaces\Company\Supplier\Product\Instance\InstanceAbstract 
{    
    public function __construct(\Entities\Company\Supplier\Product\Simple $SimpleProduct)
    {
	parent::__construct($SimpleProduct);
    }
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
    
    /**
     * @return \Dataservice_Price
     */
    public function getPriceSafe()
    {
	try
	{
	    $Price = $this->getPrice();
	}
	catch (\Exception $exc)
	{
	    $Price = new \Dataservice_Price();
	}
	
	return $Price;
    }
    
    public function getDisplayArray()
    {
	$Simple = $this->getProduct();
	
	return array(
	    "Part#"	=> $Simple->getPartNumber(),
	    "Supplier"	=> $Simple->getSupplier()->getName(),
	    "Name"	=> $Simple->getName(),
	    "Price"	=> $Simple->getPrice()->getPrice()
	);
    }
}
