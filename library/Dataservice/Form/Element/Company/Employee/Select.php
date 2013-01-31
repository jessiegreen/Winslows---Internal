<?php
/**
 * Description of EmployeeSelect
 *
 * @author jgreen
 */
class Dataservice_Form_Element_Company_Employee_Select extends Zend_Form_Element_Select 
{
    public function init() 
    {	
        $this->addMultiOption("", 'Please select...');
	
        foreach (Services\Company::factory()->getCurrentCompany()->getEmployees() as $Employee) 
	{
            $this->addMultiOption($Employee->getId(), $Employee->getFullName());
        }
    }
}