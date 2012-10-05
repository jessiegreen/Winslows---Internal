<?php
namespace Interfaces\Company\Lead\Quote\Item;

interface SaleType
{
    public function isProductAllowed(\Entities\Company\Supplier\Product\ProductAbstract $Product);
    
    public function getName();
    
    public function isApproved();
    
    public function getDue();
    
    public function getFees();
}