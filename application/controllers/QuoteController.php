<?php

/**
 * 
 * @author jessie
 *
 */

class QuoteController extends Dataservice_Controller_Action
{    
    public function init(){
	$this->view->headScript()->appendFile("/javascript/quote/quote.js");
	parent::init();
    }
    
    public function viewAction()
    {
	$this->view->headScript()->appendFile("/javascript/jquery.colorbox.js");
	$this->view->headLink()->appendStylesheet('/css/jquery.colorbox.css');
	$Quote = $this->getEntityFromParamFields("Quote", array("id"));
	
	if(!$Quote->getId()){
	    $this->_FlashMessenger->addErrorMessage("Could not get Quote");
	    $this->_History->goBack();
	}
	
	$this->view->Quote	= $Quote;
    }
    
    public function editAction()
    {
	$Quote   = $this->getEntityFromParamFields("Quote", array("id"));
	$lead_id = $this->_request->getParam("lead_id", null);
	
	if(!$Quote->getId() && $lead_id){
	    $Lead = $this->_em->find("Entities\Lead", $lead_id);
	    if($Lead)$Quote->setLead($Lead);
	    $Employee = Services\Auth::factory()->getIdentityPerson();
	    $Quote->setEmployee($Employee);
	}
	
	$form = new Form_Quote(array("method" => "post"), $Quote);
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$quote_data	= $this->_params["quote"];
		$Lead = $this->_em->find("Entities\Lead", $quote_data["lead_id"]);
		if($Lead)$Quote->setLead($Lead);
		$Employee = $this->_em->find("Entities\Employee", $quote_data["employee_id"]);
		if($Employee)$Quote->setEmployee($Employee);
		$Quote->setTotal(0);
		$Quote->populate($quote_data);
		$this->_em->persist($Quote);
		$this->_em->flush();

		$message = "Quote saved";
		$this->_FlashMessenger->addSuccessMessage($message);
		$this->_History->goBack();
	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->form	= $form;
	$this->view->Quote	= $Quote;
    }
    
    public function productaddAction()
    {
	
    }
    
    public function productadd1Action()
    {
	$this->_helper->layout->setLayout("blank");
	$quote_id   = $this->_request->getParam("id", null);
	$form	    = new Form_Quote_AddProduct(array("id" => "quote_addproduct", "name" => "quote_addproduct"));
	$this->view->form	= $form;
	$this->view->quote_id	= $quote_id;
    }
    
    public function productadd2Action()
    {
	$this->_helper->layout->setLayout("blank");
	$this->view->error  = false;
	$product_id	    = $this->_request->getParam("product_id", null);
	$quote_id	    = $this->_request->getParam("id", null);
	$Product	    = $this->_em->find("Entities\Product", $product_id);
	/* @var $Product \Entities\Product */
	
	if($Product->getId()){
	    $this->view->type	    = $Product->getDescriminator();
	    $this->view->form	    = new Form_Quote_AddProduct2(array("id" => "quote_addproduct2", "name" => "quote_addproduct2"));
	    $this->view->quote_id   = $quote_id;
	    $this->view->product_id = $product_id;
	}
	else{
	    $this->_FlashMessenger->addErrorMessage("There was an error. Please Contact Administrator");
	    $this->view->error = true;
	}
    }
    
    public function productaddmanualAction(){
	$this->_helper->layout->setLayout("blank");
	$product_id	    = $this->_request->getParam("product_id", null);
	$quote_id	    = $this->_request->getParam("id", null);
	$Product	    = $this->_em->find("Entities\Product", $product_id);
	$QuoteProduct	    = new Entities\QuoteProduct;
	/* @var $QuoteProduct \Entities\QuoteProduct */
	$QuoteProduct->setProduct($Product);
	/* @var $Product \Entities\Product */
	
	if($Product->getId()){
	    $this->view->type	    = $Product->getDescriminator();
	    $this->view->form	    = new Form_QuoteProduct($QuoteProduct, array("id" => "quote_addproductmanual", "name" => "quote_addproductmanual"));
	    $this->view->quote_id   = $quote_id;
	    $this->view->product_id = $product_id;
	}
	else{
	    $this->_FlashMessenger->addErrorMessage("There was an error. Please Contact Administrator");
	}
    }
}

