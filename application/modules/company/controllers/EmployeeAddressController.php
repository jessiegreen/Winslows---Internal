<?php
class Company_EmployeeAddressController extends Dataservice_Controller_Crud_Action
{    
    public function init() 
    {
	$this->_EntityClass = "Entities\Company\Employee\Address";
	
	parent::init();
    }
}

