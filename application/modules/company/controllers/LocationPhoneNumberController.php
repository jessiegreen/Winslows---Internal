<?php
class Company_LocationPhoneNumberController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Location\PhoneNumber";
	
	parent::init();
    }
}

