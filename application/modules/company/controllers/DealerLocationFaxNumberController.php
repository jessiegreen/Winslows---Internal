<?php
class Company_DealerLocationFaxNumberController extends Dataservice_Controller_Crud_Action
{    
    public function init() 
    {
	$this->_EntityClass = "Entities\Company\Dealer\Location\FaxNumber";
	
	parent::init();
    }
}

