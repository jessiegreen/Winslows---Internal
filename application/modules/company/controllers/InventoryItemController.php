<?php
class Company_InventoryItemController extends Dataservice_Controller_Crud_Action
{    
    public function init() 
    {
	$this->_EntityClass = "Entities\Company\Inventory\Item";
	
	parent::init();
    }
}

