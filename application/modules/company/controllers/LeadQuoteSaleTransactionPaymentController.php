<?php

class Company_LeadQuoteSaleTransactionPaymentController extends Dataservice_Controller_Action
{    
    public function cashAction()
    {
	$Sale = $this->_getSale();

	$this->_CheckRequiredSaleExists($Sale);
	
	$form = new Forms\Company\Lead\Quote\Sale\Transaction\Payment\Cash();
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try
	    {
		$data = $this->_getParam("company_lead_quote_sale_payment_transaction_payment_cash");
		$Cash = new Entities\Company\Sale\Transaction\Payment\Cash();

		$Cash->populate($data);
		$Sale->addTransaction($Cash);

		$this->_em->persist($Sale);
		$this->_em->flush();
		
		$this->_FlashMessenger->addSuccessMessage("Transaction Saved");
		$this->_History->goBack();
	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->Sale   = $Sale;
	$this->view->form   = $form;
    }
    
    public function creditCardAction()
    {
	$Sale = $this->_getSale();

	$this->_CheckRequiredSaleExists($Sale);
	
	$form = new Forms\Company\Lead\Quote\Sale\Transaction\Payment\CreditCard();
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try
	    {
		$data = $this->_getParam("company_lead_quote_sale_payment_transaction_payment_creditcard");
		
		require_once 'AuthorizeNet/AuthorizeNet.php'; // Make sure this path is correct.
		
		$transaction		= new AuthorizeNetAIM('79RfK5wW5h6f', '54289CsdmzQtPA43');
		$transaction->amount	= $data["amount"];
		$transaction->card_num	= $data["cc_num"];
		$transaction->exp_date	= $data["exp_month"]."/".$data["exp_year"];
		$response		= $transaction->authorizeAndCapture();
		$CreditCard		= new Entities\Company\Sale\Transaction\Payment\PaymentGateway\CreditCard();
		$PaymentGateway		= $this->_em->getRepository("Entities\Company\PaymentGateway")->findOneBy(array("name_index" => "authorizenet"));

		if($response->approved)
		{
		    $CreditCard->setAmount($data["amount"]);
		    $CreditCard->setApproved($response->approved);
		    $CreditCard->setLastFour(substr($response->account_number, -4, 4));
		    $CreditCard->setAuthorizationCode($response->authorization_code);
		    $CreditCard->setTransactionId($response->transaction_id);
		    $CreditCard->setResponseCode($response->response_code);
		    $CreditCard->setCardType($response->card_type);
		    $CreditCard->setPaymentGateway($PaymentGateway);
		    $CreditCard->setResponseString($response->response);

		    $Sale->addTransaction($CreditCard);

		    $this->_em->persist($Sale);
		    $this->_em->flush();
		    
		    $this->_FlashMessenger->addSuccessMessage("Transaction Approved");
		}
		else $this->_FlashMessenger->addErrorMessage("Transaction Declined - ".$response->response_reason_text);
		
		$this->_History->goBack();
	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->Sale   = $Sale;
	$this->view->form   = $form;
    }
    
    public function checkAction()
    {
	$Sale = $this->_getSale();

	$this->_CheckRequiredSaleExists($Sale);
	
	$form = new Forms\Company\Lead\Quote\Sale\Transaction\Payment\Check();
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try
	    {
		$data	= $this->_getParam("company_lead_quote_sale_payment_transaction_payment_check");
		$Check	= new Entities\Company\Sale\Transaction\Payment\Check();

		$Check->populate($data);
		$Sale->addTransaction($Check);

		$this->_em->persist($Sale);
		$this->_em->flush();
		
		$this->_FlashMessenger->addSuccessMessage("Transaction Saved");
		$this->_History->goBack();
	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->Sale   = $Sale;
	$this->view->form   = $form;
    }
    
    /**
     * @return \Entities\Company\Lead\Quote\Sale
     */
    private function _getSale()
    {
	$id	= $this->getRequest()->getParam("sale_id", 0);
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

