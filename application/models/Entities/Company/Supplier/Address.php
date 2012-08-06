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
     * @ManyToOne(targetEntity="\Entities\Company\Supplier", inversedBy="Addresses")
     * @var \Entities\Company\Supplier $Supplier
     */     
    private $Supplier;
    
    /**
     * @param \Entities\Company\Supplier $Supplier
     */
    public function setSupplier(\Entities\Company\Supplier $Supplier)
    {
        $this->Supplier = $Supplier;
    }
    
    /**
     * @return \Entities\Company\Supplier
     */
    public function getSupplier()
    {
	return $this->Supplier;
    }
    
    public function populate(array $array)
    {
	foreach ($array as $key => $value) 
	{
	    if(property_exists($this, $key))
	    {
		$this->$key = $value;
	    }
	}
    }
}