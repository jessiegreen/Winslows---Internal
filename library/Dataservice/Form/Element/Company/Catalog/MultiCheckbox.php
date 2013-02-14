<?php
class Dataservice_Form_Element_Company_Catalog_MultiCheckbox extends Zend_Form_Element_MultiCheckbox
{
    public function init()
    {	
	$Company = \Services\Company\Website::factory()->getCurrentWebsite()->getCompany();
	
        foreach ($Company->getCatalogs() as $Catalog)
	{
            $this->addMultiOption($Catalog->getId(), $Catalog->getName());
        }
    }
}