<?php

class Company_LeadQuoteController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Lead\Quote";
	
	parent::init();
    }
    
    public function viewSalesAction()
    {
	$Quote	    = $this->_getQuote();
	$Employee   = $this->_Website->getCurrentUserAccount(Zend_Auth::getInstance())->getPerson();
	
	$this->_CheckRequiredQuoteExists($Quote);
	
	if(!$Employee->canSeeLead($Quote->getLead()))
	{
	    $this->_FlashMessenger->addErrorMessage("You are not allowed to view Lead's Quote");
	    $this->_History->goBack();
	}
	
	$this->view->Quote = $Quote;
    }
    
    public function addInventoryItemAction()
    {
	$Quote = $this->_getQuote();
	
	$this->_CheckRequiredQuoteExists($Quote);
	
	if($this->getRequest()->isPost())
	{
	    $inventory_item_id = $this->getRequest()->getParam("inventory_item_id");
	    
	    if($inventory_item_id)
	    {
		$Item = $this->_em->getRepository("Entities\Company\Inventory\Item")->find($inventory_item_id);
		
		if($Item)
		{
		    try
		    {
			/* @var $Instance Entities\Company\Supplier\Product\Instance\InstanceAbstract */
			$Instance	= $Item->getInstance();
			$clonedInstance = $Instance->cloneInstance();
			$QuoteItem	= new Entities\Company\Lead\Quote\Item;
			
			$QuoteItem->setInstance($clonedInstance);
			$QuoteItem->setName("Inventory Item #".$inventory_item_id);
			$QuoteItem->setQuantity(1);

			$Quote->addItem($QuoteItem);

			$this->_em->persist($Quote);
			$this->_em->flush();
			
			$this->_FlashMessenger->addSuccessMessage("Item Added");
		    }
		    catch (Exception $exc)
		    {
			$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		    }
		}
	    }
	    
	    $this->_History->goBack();
	}
	
	$this->view->Quote = $Quote;
    }
    
    public function itemremoveAction()
    {
	$this->_helper->layout->setLayout("blank");
	$this->_helper->viewRenderer->setNoRender(true);
	
	$Quote  = $this->_getQuote();
	$Item	= $this->_getItem();
	
	$this->_CheckRequiredQuoteExists($Quote);
	$this->_CheckRequiredItemExists($Item);
	
	try 
	{
	    $this->_em->remove($Item);
	    $this->_em->flush();
	    $this->_FlashMessenger->addSuccessMessage("Item removed");
	} 
	catch (Exception $exc)
	{
	    $this->_FlashMessenger->addErrorMessage($exc->getMessage());
	}
	
	$this->_History->goBack();
    }
    
    public function itemaddmanualsaveAction()
    {
	$this->_helper->layout->setLayout("blank");
	$this->_helper->viewRenderer->setNoRender(true);
	
	$return			    = array();
	$return["success"]	    = true;
	$return["error_message"]    = "";
	$error_message		    = array();
	$values			    = array();
	$Quote			    = $this->_getQuote();
	$Product		    = $this->_getProduct();
	
	$this->_CheckRequiredQuoteExists($Quote);
	$this->_CheckRequiredProductExists($Product);
	
	$ConfigurableInstance	= new Entities\Company\Supplier\Product\Configurable\Instance($Product);
	$Item			= new Entities\Company\Lead\Quote\Item;
	
	$Item->setQuote($Quote);
	
	if($this->getRequest()->isPost())
	{	    
	    $data = $this->getRequest()->getPost();
	    
	    foreach($data as $option_id => $option_array)
	    {
		$Option		    = $this->_em->find(
					    "\Entities\Company\Supplier\Product\Configurable\Option", 
					    $option_id
					);
		/* @var $Option \Entities\Company\Supplier\Product\Configurable\Option */
		$Category		= $Option->getCategory();
		$required_parameters	= $Option->getRequiredParameters();
		$required_message	= $Category->getName()." - ".$Option->getName()." - %s is required.";
		
		#--Check that all required parameters exist in post
		foreach ($required_parameters as $Parameter) 
		{
		    if(!key_exists($Parameter->getId(), $option_array))
			$error_message[] = sprintf($required_message, $Parameter->getName());
		}
		
		#--Check that required options have a value if so then add
		foreach($option_array as $parameter_id => $value_id)
		{
		    $Parameter = $this->_em->find(
				    "\Entities\Company\Supplier\Product\Configurable\Option\Parameter", 
				    $parameter_id
				 );
		    
		    /* @var $Parameter \Entities\Company\Supplier\Product\Configurable\Option\Parameter */
		    if($Parameter->isRequired() && !$value_id)
		    {
			$error_message[] = sprintf($required_message, $Parameter->getName());
		    }
		    elseif(!$value_id) {
			
		    }
		    else{
			$Value = $this->_em->find(
				    "\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value", 
				    $value_id
				);
			
			if($Value)$values[] = $Value;
			else $error_message[] = $Category->getName()." - ".$Option->getName().
					    " - ".$Parameter->getName()." $value_id is not valid.";
		    }
		}
	    }
	    if(count($error_message)>0){
		$return["success"] = false;
		$return["error_message"] = implode("<br />",$error_message);
	    }
	    else{
		try {
		    foreach ($values as $Value)
		    {
			$ConfigurableInstance->addValue($Value);
		    }
		    $ConfigurableInstance->setNote("");
		    
		    $Item->setInstance($ConfigurableInstance);
		    $Item->setQuantity(1);
		    $Quote->addItem($Item);
		    $this->_em->persist($ConfigurableInstance);
		    $this->_em->persist($Item);
		    $this->_em->persist($Quote);
		    $this->_em->flush();
		} 
		catch (Exception $exc) 
		{
		    $return["success"] = false;
		    $return["error_message"] .= "<br />".$exc->getMessage();
		}
	    }
	}
	else{
	    $return["success"]		= false;
	    $return["error_message"]	= "Invalid Request or Missing Quote or Product Id";
	}
	echo json_encode($return);
    }
    
    public function payAction()
    {
	$Quote		= $this->_getQuote();
	
	$this->_CheckRequiredQuoteExists($Quote);
    }
    
    /**
     * @return Entities\Company\Lead
     */
    private function _getLead()
    {
	$id = $this->getRequest()->getParam("lead_id", 0);
	return $this->_em->find("Entities\Company\Lead", $id);
    }
    
    private function _CheckRequiredLeadExists(\Entities\Company\Lead $Lead)
    {
	if(!$Lead->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Lead");
	    $this->_History->goBack();
	}
    }
    
    /**
     * @return Entities\Company\Supplier\Product\ProductAbstract
     */
    private function _getProduct()
    {
	$id = $this->getRequest()->getParam("product_id", 0);
	return $this->_em->find("Entities\Company\Supplier\Product\ProductAbstract", $id);
    }
    
    private function _CheckRequiredProductExists(Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	if(!$Product->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Product");
	    $this->_History->goBack();
	}
    }
    
    /**
     * @return Entities\Company\Lead\Quote\Item
     */
    private function _getItem()
    {
	$id = $this->getRequest()->getParam("item_id", 0);
	return $this->_em->find("Entities\Company\Lead\Quote\Item", $id);
    }
    
    private function _CheckRequiredItemExists(Entities\Company\Lead\Quote\Item $Item)
    {
	if(!$Item->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Item");
	    $this->_History->goBack();
	}
    }
}

