<?php
class Company_EmployeePhoneNumberController extends Dataservice_Controller_Crud_Action
{    
    public function init() 
    {
	$this->_EntityClass = "Entities\Company\Employee\PhoneNumber";
	
	parent::init();
    }
}

