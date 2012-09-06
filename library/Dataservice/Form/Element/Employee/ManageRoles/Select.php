<?php

class Dataservice_Form_Element_Employee_ManageRoles_Select extends Zend_Form_Element_Select
{
    public function init()
    {	
        $this->addMultiOption("", 'Please select...');
	
        foreach (Services\Company\Employee\Role::factory()->getAllRoles() as $Role)
	{
            $this->addMultiOption($Role->getId(), $Role->getName());
        }
    }
}