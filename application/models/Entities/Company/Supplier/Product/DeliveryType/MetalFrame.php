<?php

namespace Entities\Company\Supplier\Product\DeliveryType;
/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\DeliveryType\MetalFrame") 
 * @Table(name="company_supplier_product_deliverytype_metalframes") 
 * @Crud\Entity\Url(value="supplier-product-delivery-type-metal-frame")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */

class MetalFrame extends DeliveryTypeAbstract
{    
    /**
     * @param \Entities\Company\Lead\Quote\Item $Item
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getOriginationAddresses(\Entities\Company\Lead\Quote\Item $Item)
    {
	return $this->_getLocationAddresses($Item);
    }
    
    /**
     * @param \Entities\Company\Lead\Quote\Item $Item
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getDestinationAddresses(\Entities\Company\Lead\Quote\Item $Item)
    {
	return $this->_getLeadAddresses($Item);
    }
    
    /**
     * @return string
     */
    public function getDescriminator() 
    {
	return parent::TYPE_MetalFrame;
    }
}