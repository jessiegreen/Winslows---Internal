<?php

namespace Entities\Company\Supplier\Product\DeliveryType;
/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\DeliveryType\LocationPickup") 
 * @Table(name="company_supplier_product_deliverytype_locationpickups") 
 */

class LocationPickup extends DeliveryTypeAbstract
{
    public function getAddresses(\Entities\Company\Lead\Quote\Item $Item)
    {
	$Addresses = new \Doctrine\Common\Collections\ArrayCollection;
	
	foreach($Item->getQuote()->getLead()->getCompany()->getLocations() as $Location)
	    $Addresses->add($Location->getAddress());
	
	return $Addresses;
    }
    
    /**
     * @return string
     */
    public function getDescriminator() 
    {
	return parent::TYPE_Location;
    }
}