<?php

/**
 * 
 * @author jessie
 *
 */

class Company_InventoryItemController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/inventory/item.js");
	
	parent::init();
    }
    
    public function viewAction()
    {
	$Item = $this->getEntityFromParamFields("Company\Inventory\Item", array("id"));
	
	if(!$Item->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Inventory Item");
	    $this->_History->goBack();
	}
	
	$this->view->Item	= $Item;
    }
    
    public function editAction()
    {
	$Item		= $this->_getItem();
	
	$this->_CheckRequiredItemExists($Item);
	
	$form = new Forms\Company\Inventory\Item($Item, array("method" => "post"));

	$form->addCancelButton($this->_History->getPreviousUrl());

	if($this->isPostAndValid($form))
	{	    
	    try 
	    {
		$item_data  = $this->_params["company_inventory_item"];
		
		if($item_data["location_id"])
		{
		    $Location = $this->_em->getRepository("Entities\Company\Location\LocationAbstract")->find($item_data["location_id"]);
		    
		    if($Location)
		    {
			$Item->setLocation($Location);
		    }
		}
		
		$Item->populate($item_data);
		$this->_em->persist($Item);
		$this->_em->flush();
		
		$this->_FlashMessenger->addSuccessMessage("Item saved");
	    } 
	    catch (Exception $exc) 
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    }
	    
	    $this->_History->goBack();
	}
	
	$this->view->form	= $form;
	$this->view->Item	= $Item;
    }
    
    /**
     * @return Entities\Company\Inventory\Item
     */
    private function _getItem()
    {
	return $this->getEntityFromParamFields("Company\Inventory\Item", array("id"));
    }
    
    private function _CheckRequiredItemExists(Entities\Company\Inventory\Item $Item)
    {
	if(!$Item->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Item");
	    $this->_History->goBack();
	}
    } 
}

