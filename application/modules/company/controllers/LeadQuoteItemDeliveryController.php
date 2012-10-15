<?php

class Company_LeadQuoteItemDeliveryController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/lead/quote/item/delivery.js");
	
	parent::init();
    }
    
    public function viewAction()
    {	
	$Delivery = $this->_getDelivery();
	
	$this->_CheckRequiredDeliveryExists($Delivery);
	
	$this->view->Delivery = $Delivery;
    }
    
    public function setAddressAction()
    {
	$Delivery = $this->_getDelivery();
	
	$this->_CheckRequiredDeliveryExists($Delivery);
	
	$form = new Forms\Company\Lead\Quote\Item\Delivery\SetAddress($Delivery);
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    $data    = $this->_request->getParam("company_lead_quote_item_delivery_setaddress");
	    
	    $Address = $this->_em->getRepository("Entities\Address\AddressAbstract")->find($data["address_id"]);
	    
	    if($Address)
	    {		
		$Delivery->setAddress($Address);
		
		$this->_em->persist($Delivery);
		$this->_em->flush();
		
		$this->_FlashMessenger->addSuccessMessage("Delivery Address Saved");
		$this->_History->goBack();
	    }
	    else
	    {
		$this->_FlashMessenger->addErrorMessage("Address does not exist");
		$this->_History->goBack();
	    }
	}
    
	$this->view->form = $form;
    }
    
    /**
     * @return Entities\Company\Lead\Quote\Item\Delivery
     */
    private function _getDelivery()
    {
	$id	    = $this->_request->getParam("id", 0);
	$Delivery   = $this->_em->find("Entities\Company\Lead\Quote\Item\Delivery", $id);
	
	if(!$Delivery)$Delivery = new Entities\Company\Lead\Quote\Item\Delivery;
	
	return $Delivery;
    }
    
    private function _CheckRequiredDeliveryExists(Entities\Company\Lead\Quote\Item\Delivery $Delivery)
    {
	if(!$Delivery->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Delivery");
	    $this->_History->goBack();
	}
    }
}

