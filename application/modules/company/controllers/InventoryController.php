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
    
    public function addItemAction()
    {
	$Inventory = $this->_getInventory();
	
	$this->_CheckRequiredInventoryExists($Inventory);
	
	$product_id = $this->_request->getParam("product_id");
	
	if($product_id)
	{
	    $Product = $this->_em->getRepository("Entities\Company\Supplier\Product\ProductAbstract")->find($product_id);
	    
	    if($Product)
	    {
		try 
		{
		    switch ($Product->getDescriminator())
		    {
			case "Simple":
			    $Instance	= new \Entities\Company\Supplier\Product\Simple\Instance($Product);
			    break;
			case "Configurable":
			    $Instance	= new Entities\Company\Supplier\Product\Configurable\Instance($Product);
			    break;
			default:
			    $this->_FlashMessenger->addErrorMessage("Could not get Instance");
			    $this->_History->goBack();
			    break;
		    }
		    
		    $Instance->setNote("Added to inventory");
		    $InventoryItem = new Entities\Company\Inventory\Item;
		    $InventoryItem->setInstance($Instance);
		    $InventoryItem->setQuantity(1);
		    $Inventory->addItem($InventoryItem);

		    $this->_em->persist($Inventory);
		    $this->_em->flush();
		    
		    $this->_redirect("/inventory-item/id/".$InventoryItem->getId());
		} 
		catch (Exception $exc)
		{
		    $this->_FlashMessenger->addErrorMessage($exc->getMessage());
		    $this->_History->goBack();
		}
	    }
	}
    }
    
    /**
     * @return Entities\Company\Inventory
     */
    private function _getInventory()
    {
	return $this->getEntityFromParamFields("Company\Inventory", array("id"));
    }
    
    private function _CheckRequiredInventoryExists(Entities\Company\Inventory $Inventory)
    {
	if(!$Inventory->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Inventory");
	    $this->_History->goBack();
	}
    } 
}

