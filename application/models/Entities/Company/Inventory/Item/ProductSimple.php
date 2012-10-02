<?php

namespace Entities\Company\Inventory\Item;

/** 
 * @Entity (repositoryClass="Repositories\Company\Inventory\Item\ProductSimples") 
 * @Table(name="company_inventory_item_productsimples") 
 * @HasLifecycleCallbacks
 */
class ProductSimple extends ItemAbstract implements \Interfaces\Company\Inventory\Item
{    
    /**
     * @OneToOne(targetEntity="\Entities\Company\Supplier\Product\Simple", cascade={"persist"}, orphanRemoval=true)
     * @var \Entities\Company\Supplier\Product\Simple $Simple
     */
    protected $Simple;
    
    /**
     * @param \Entities\Company\Supplier\Product\Simple $Simple
     */
    public function setSimple(\Entities\Company\Supplier\Product\Simple $Simple)
    {
	$this->Simple = $Simple;
    }
    
    /**
     * @return \Entities\Company\Supplier\Product\Simple
     */
    public function getSimple()
    {
	return $this->Simple;
    }
    
    public function getDisplayFields()
    {
	$Simple = $this->getSimple();
	
	return array(
	    "Part#"	=> $Simple->getPartNumber(),
	    "Supplier"	=> $Simple->getSupplier()->getName(),
	    "Name"	=> $Simple->getName(),
	    "Price"	=> $Simple->getPrice()
	);
    }
    
    /**
     * @return string
     */
    public function getDescriminator()
    {
	return static::TYPE_ProductSimple;
    }
}
