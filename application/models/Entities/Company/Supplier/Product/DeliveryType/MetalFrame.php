<?php

namespace Entities\Company\Supplier\Product\DeliveryType;
/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\DeliveryType\MetalFrame") 
 * @Table(name="company_supplier_product_deliverytype_metalframes") 
 */

class MetalFrame extends DeliveryTypeAbstract
{
    public function getAddresses(\Entities\Company\Lead\Quote\Item $Item)
    {
	return $Item->getQuote()->getLead()->getAddresses();
    }
    
    /**
     * @return string
     */
    public function getDescriminator() 
    {
	return parent::TYPE_MetalFrame;
    }
}