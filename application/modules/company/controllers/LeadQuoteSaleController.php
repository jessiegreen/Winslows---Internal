<?php

class Company_LeadQuoteSaleController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/lead/quote/sale.js");
	
	parent::init();
    }
    
    public function summaryAction()
    {
	$Quote		= $this->_getQuote();
	$payment_form	= new \Forms\Company\Lead\Quote\Sale\PaymentTypes();
	
	$this->_CheckRequiredQuoteExists($Quote);
	
	$Result = $Quote->isValid();
	
	if(!$Result->isValid())
	{
	    $this->_FlashMessenger->addErrorMessage(implode ("<br />",$Result->getErrorMessages()));
	    $this->_History->goBack();
	}
	
	if(!$Quote->getSale())
	{
	    $Sale = new \Entities\Company\Lead\Quote\Sale ($Quote);
	    $this->_em->persist($Sale);
	    $this->_em->flush();
	}
	else $Sale = $Quote->getSale();
	
	$this->view->Sale	    = $Sale;
	$this->view->payment_form   = $payment_form;
    }
    
    /**
     * @return \Entities\Company\Lead\Quote
     */
    private function _getQuote()
    {
	$id	= $this->_request->getParam("quote_id", 0);
	$Quote	= $this->_em->find("Entities\Company\Lead\Quote", $id);
	
	if(!$Quote)$Quote = new \Entities\Company\Lead\Quote;
	
	return $Quote;
    }
    
    private function _CheckRequiredQuoteExists(\Entities\Company\Lead\Quote $Quote)
    {
	if(!$Quote->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Quote");
	    $this->_History->goBack();
	}
    }
}

