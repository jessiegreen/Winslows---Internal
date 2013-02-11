<?php
namespace Interfaces\Company\Supplier;

interface Product
{
    public function createInstance();
    
    public function getDescriminator();
}