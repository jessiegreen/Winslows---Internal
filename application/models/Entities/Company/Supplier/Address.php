<?php
namespace Entities\Company\Supplier;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Address") 
 * @Table(name="company_supplier_addresses") 
 * @Crud\Entity\Url(value="supplier-address")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
class Address extends \Entities\Company\Address\AddressAbstract
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