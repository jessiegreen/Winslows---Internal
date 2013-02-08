<?php
class Company_InventoryController extends Dataservice_Controller_Crud_Action
{    
    public function init() 
    {
	$this->_EntityClass = "Entities\Company\Inventory";
	
	parent::init();
    }
    
    public function addItemAction()
    {	
	$product_id = $this->getRequest()->getParam("product_id");
	
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

		    $this->_em->persist($this->_Entity);
		    $this->_em->flush();
		    
		    $this->_redirect("/inventory-item/view/id/".$InventoryItem->getId());
		} 
		catch (Exception $exc)
		{
		    $this->_FlashMessenger->addErrorMessage($exc->getMessage());
		    $this->_History->goBack();
		}
	    }
	}
    }
}

