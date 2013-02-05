<?php
class Company_LeadAddressController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Lead\Address";
	
	parent::init();
    }
}

