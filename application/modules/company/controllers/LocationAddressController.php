<?php
class Company_LocationAddressController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Location\Address";
	
	parent::init();
    }
}

