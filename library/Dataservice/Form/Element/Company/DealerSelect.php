<?php
class Dataservice_Form_Element_Company_DealerSelect extends Zend_Form_Element_Select
{
    public function init()
    {	
        $this->addMultiOption("", 'Please select...');
	
        foreach (Services\Company\Dealer::factory()->getAllDealers() as $Dealer)
	{
            $this->addMultiOption($Dealer->getId(), $Dealer->getName());
        }
    }
}