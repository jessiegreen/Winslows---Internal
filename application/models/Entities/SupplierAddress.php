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
namespace Entities;
/** 
 * @Entity (repositoryClass="Repositories\SupplierAddress") 
 * @Table(name="supplieraddress") 
 */

class SupplierAddress extends Address
{
    private $supplier_id;
    /** 
     * @ManyToOne(targetEntity="Supplier", inversedBy="supplieraddresses")
     */     
    private $supplier;
    
    
    /**
     * Add supplier to address.
     * @param Supplier $supplier
     */
    public function setSupplier(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }
    
    /**
     * Retrieve address's associated supplier.
     */
    public function getSupplier()
    {
	return $this->supplier;
    }
    
    /**
     * Get supplier Id
     */
    public function getSupplierId() {
	return $this->supplier_id;
    }
}

?>
