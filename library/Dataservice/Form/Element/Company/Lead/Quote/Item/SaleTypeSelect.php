<?php
/**
 * Description of LocationSelect
 *
 * @author jgreen
 */
class Dataservice_Form_Element_Company_Lead_Quote_Item_SaleTypeSelect extends Zend_Form_Element_Select
{
    public function init()
    {	
        $this->addMultiOption("", 'Please select...');
	
        foreach (Services\Company\Lead\Quote\Item\SaleType::factory()->getAllSaleTypes() as $SaleType)
	{
            $this->addMultiOption($SaleType->getId(), $SaleType->getName());
        }
    }
}