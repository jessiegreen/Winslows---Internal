<?php
/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
namespace Entities\Company\Supplier;
/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Address") 
 * @Table(name="company_supplier_addresses") 
 */

class Address extends \Entities\Address\AddressAbstract
{
    /** 
     * @ManyToOne(targetEntity="Supplier", inversedBy="SupplierAddresses")
     */     
    private $Supplier;
    
    
    /**
     * Add supplier to address.
     * @param Supplier $Supplier
     */
    public function setSupplier(Supplier $Supplier)
    {
        $this->Supplier = $Supplier;
    }
    
    /**
     * Retrieve address's associated supplier.
     */
    public function getSupplier()
    {
	return $this->Supplier;
    }
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}