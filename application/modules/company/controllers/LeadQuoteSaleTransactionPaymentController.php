<?php

class Company_LeadQuoteSaleTransactionPaymentController extends Dataservice_Controller_Action
{    
    public function cashAction()
    {
	$Sale = $this->_getSale();

	$this->_CheckRequiredSaleExists($Sale);
	
	$form = \Forms\Company\Sale\Transaction\Payment\Cash();
	
	$this->view->Sale   = $Sale;
	$this->view->form   = $form;
    }
    
    /**
     * @return \Entities\Company\Lead\Quote\Sale
     */
    private function _getSale()
    {
	$id	= $this->_request->getParam("sale_id", 0);
	$Sale	= $this->_em->find("Entities\Company\Lead\Quote\Sale", $id);
	
	if(!$Sale)$Sale = new \Entities\Company\Lead\Quote;
	
	return $Sale;
    }
    
    private function _CheckRequiredSaleExists(\Entities\Company\Lead\Quote\Sale $Sale)
    {
	if(!$Sale->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Sale");
	    $this->_History->goBack();
	}
    }
}

