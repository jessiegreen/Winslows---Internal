<?php
class Company_DealerLocationPhoneNumberController extends Dataservice_Controller_Crud_Action
{    
    public function init() 
    {
	$this->_EntityClass = "Entities\Company\Dealer\Location\PhoneNumber";
	
	parent::init();
    }
}

