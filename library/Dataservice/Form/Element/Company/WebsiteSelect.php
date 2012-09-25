<?php
/**
 * Description of EmployeeSelect
 *
 * @author jgreen
 */
class Dataservice_Form_Element_Company_WebsiteSelect extends Zend_Form_Element_Select 
{
    public function init() 
    {	
        $this->addMultiOption("", 'Please select...');
	
        foreach (Services\Company\Website::factory()->getAllWebsites() as $Website) 
	{
            $this->addMultiOption($Website->getId(), $Website->getName());
        }
    }
}