<?php

class Dataservice_Form_Element_Company_Supplier_Product_DeliveryTypeMultiCheckbox extends Zend_Form_Element_MultiCheckbox
{
    public function init()
    {
        foreach(Services\Company\Supplier\Product\DeliveryType::factory()->getAllDeliveryTypes() as $DeliveryType)
	{	    
            $this->addMultiOption($DeliveryType->getId(), $DeliveryType->getName());
        }
    }
}