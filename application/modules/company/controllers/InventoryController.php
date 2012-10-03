<?php

/**
 * 
 * @author jessie
 *
 */

class Company_InventoryController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/inventory.js");
	
	parent::init();
    }
    
    public function viewAction()
    {
	$Inventory = $this->getEntityFromParamFields("Company\Inventory", array("id"));
	if(!$Inventory->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Inventory");
	    $this->_History->goBack();
	}
	
	$this->view->Inventory	= $Inventory;
    }
}

