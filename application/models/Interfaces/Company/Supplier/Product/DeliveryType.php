<?php
namespace Interfaces\Company\Supplier\Product;

interface DeliveryType
{
    public function getOriginationAddresses(\Entities\Company\Lead\Quote\Item $Item);
    
    public function getDestinationAddresses(\Entities\Company\Lead\Quote\Item $Item);
    
    public function getDescriminator();
}