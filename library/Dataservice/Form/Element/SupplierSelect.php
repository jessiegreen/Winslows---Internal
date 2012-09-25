<?php
class Dataservice_Form_Element_SupplierSelect extends Zend_Form_Element_Select
{
    public function init()
    {	
        $this->addMultiOption("", 'Please select...');
	
        foreach (Services\Company\Supplier::factory()->getAllSuppliers() as $Supplier)
	{
            $this->addMultiOption($Supplier->getId(), $Supplier->getName());
        }
    }
}