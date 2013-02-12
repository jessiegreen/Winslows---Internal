<?php
class Dataservice_Form_Element_Company_Website_MultiCheckbox extends Zend_Form_Element_MultiCheckbox
{
    public function init()
    {	
	$Company = \Services\Company\Website::factory()->getCurrentWebsite()->getCompany();
	
        foreach ($Company->getWebsites() as $Website)
	{
            $this->addMultiOption($Website->getId(), $Website->getName());
        }
    }
}