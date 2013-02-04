<?php
class Company_DealerLocationController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Dealer\Location";
	
	parent::init();
    }
}