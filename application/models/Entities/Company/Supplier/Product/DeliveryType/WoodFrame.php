<?php

namespace Entities\Company\Supplier\Product\DeliveryType;
/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\DeliveryType\WoodFrame") 
 * @Table(name="company_supplier_product_deliverytype_woodframes") 
 */

class WoodFrame extends DeliveryTypeAbstract
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
	return parent::TYPE_WoodFrame;
    }
}