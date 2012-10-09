<?php
namespace Interfaces\Company\Lead\Quote\Item;

interface SaleType
{
    public function isProductAllowed(\Entities\Company\Supplier\Product\ProductAbstract $Product);
    
    public function getName();
    
    public function getPaymentsTotalAmountPrice(\Dataservice_Price $Price);
    
    public function getFeesPrice(\Dataservice_Price $Price);
    
    public function getDownPaymentPrice(\Dataservice_Price $Price);
    
    public function getPaymentsCount();
    
    public function getPaymentsAmountPrice(\Dataservice_Price $Price);
}