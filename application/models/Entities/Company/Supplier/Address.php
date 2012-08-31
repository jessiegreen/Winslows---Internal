<?php
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
}