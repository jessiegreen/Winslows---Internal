<?php
class Company_DealerController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Dealer";
	
	parent::init();
    }
}

