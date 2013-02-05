<?php
class Company_EmployeeFaxNumberController extends Dataservice_Controller_Crud_Action
{    
    public function init() 
    {
	$this->_EntityClass = "Entities\Company\Employee\FaxNumber";
	
	parent::init();
    }
}

