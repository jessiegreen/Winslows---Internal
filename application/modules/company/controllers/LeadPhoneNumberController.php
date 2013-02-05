<?php
class Company_LeadPhoneNumberController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Lead\PhoneNumber";
	
	parent::init();
    }
}

