<?php
namespace Interfaces\Company\Supplier\Product\Instance;

interface InstanceAbstract
{
    /**
     * @return \Dataservice_Price
     */
    public function getPrice();
    
    public function getPriceSafe();
    
    public function getDisplayArray();
    
    public function cloneInstance();
}
