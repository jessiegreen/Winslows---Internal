<?php

class Dataservice_Form_Element_Company_Website_Select extends Zend_Form_Element_Select
{
    public function init()
    {	
        $this->addMultiOption("", 'Please select...');
	
        foreach (Services\Company::factory()->getCurrentCompany()->getWebsites() as $Website)
	{
            $this->addMultiOption($Website->getId(), $Website->getName());
        }
    }
}