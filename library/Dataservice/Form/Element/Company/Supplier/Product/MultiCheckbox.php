<?php
class Dataservice_Form_Element_Company_Supplier_Product_MultiCheckbox extends Zend_Form_Element_MultiCheckbox
{
    public function init()
    {
        foreach(Services\Company\Supplier\Product::factory()->getAllProducts() as $Product)
	{
            $this->addMultiOption($Product->getId(), $Product->getName());
        }
    }
}