<?php

namespace Entities\Company\Supplier\Product\DeliveryType;
/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\DeliveryType\LocationPickup") 
 * @Table(name="company_supplier_product_deliverytype_locationpickups") 
 */

class LocationPickup extends DeliveryTypeAbstract
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
	return $this->_getLocationAddresses($Item);
    }
    
    /**
     * @return string
     */
    public function getDescriminator() 
    {
	return parent::TYPE_Location;
    }
}