<?php

class Company_LeadQuoteItemController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/lead/quote/item.js");
	
	parent::init();
    }
    
    public function viewAction()
    {	
	$Item = $this->_getItem();
	
	$this->view->Item = $Item;
    }
    
    public function editAction()
    {
	$Item	    = $this->_getItem();
	$quote_id   = $this->_request->getParam("quote_id");
	
	if(!$Item->getId() && $quote_id && ($Quote = $this->_getQuote()) && $Quote->getId())
	{
	    $Item->setQuote($Quote);
	}
	
	$form = new Forms\Company\Lead\Quote\Item($Item, array("method" => "post"));
	
	if($form->getSubform("company_lead_quote_item")->getElement("product_id"))
	    $form->getSubform("company_lead_quote_item")->getElement("product_id")->setAttrib("required", true);

	$form->addCancelButton($this->_History->getPreviousUrl());

	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$item_data  = $this->_params["company_lead_quote_item"];

		if(!$Item->getInstance())
		{
		    $Product = $this->_em->find("Entities\Company\Supplier\Product\ProductAbstract", $item_data["product_id"]);
		    
		    if($Product->getId())
		    {
			$class	    = "Entities\Company\Supplier\Product\\".$Product->getDescriminator()."\Instance";
			/* @var $Instance Entities\Company\Supplier\Product\Instance\InstanceAbstract */
			$Instance   = new $class($Product);
			
			if($Instance)$Item->setInstance($Instance);
		    }
		    
		    $Item->getInstance()->setNote("Added To Quote #".$Item->getQuote()->getId());
		}
		
		if($item_data["sale_type_id"])
		{
		    $SaleType = Services\Company\Lead\Quote\Item\SaleType::factory()->find($item_data["sale_type_id"]);
		    
		    if($SaleType)
		    {
			$Item->setSaleType($SaleType);
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
     * @return Entities\Company\Lead\Quote\Item
     */
    private function _getItem()
    {
	$id = $this->_request->getParam("id", 0);
	
	$Item = $this->_em->find("Entities\Company\Lead\Quote\Item", $id);
	
	if(!$Item)$Item = new Entities\Company\Lead\Quote\Item;
	
	return $Item;
    }
    
    private function _CheckRequiredItemExists(Entities\Company\Lead\Quote\Item $Item)
    {
	if(!$Item->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Item");
	    $this->_History->goBack();
	}
    }
    
    /**
     * @return Entities\Company\Lead\Quote
     */
    private function _getQuote()
    {
	$id = $this->_request->getParam("quote_id", 0);
	return $this->_em->find("Entities\Company\Lead\Quote", $id);
    }
    
    private function _CheckRequiredLeadExists(\Entities\Company\Lead\Quote $Quote)
    {
	if(!$Quote->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Quote");
	    $this->_History->goBack();
	}
    }
}

