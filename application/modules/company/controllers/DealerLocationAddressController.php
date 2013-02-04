<?php
class Company_DealerLocationAddressController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Dealer\Location\Address";
	
	parent::init();
    }
}