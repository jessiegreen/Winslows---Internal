<?php
class Company_EmployeeEmailAddressController extends Dataservice_Controller_Crud_Action
{    
    public function init() 
    {
	$this->_EntityClass = "Entities\Company\Employee\EmailAddress";
	
	parent::init();
    }
}