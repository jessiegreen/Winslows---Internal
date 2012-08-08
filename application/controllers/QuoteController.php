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
	$this->view->headScript()->appendFile("/javascript/jquery/jquery-ui.min.js");
	$this->view->headLink()->prependStylesheet('/css/jquery-ui/flick/jquery-ui.custom.css');
	parent::init();
    }
    
    public function viewAction()
    {
	$this->view->headScript()->appendFile("/javascript/jquery/jquery.colorbox.js");
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
	$Product	    = $this->_em->find("Entities\ConfigurableProduct", $product_id);
	
	/* @var $Product \Entities\ConfigurableProduct */
	$data		    = array();
	if($Product->getId()){
	    /* @var $OptionGroup \Entities\ConfigurableProductOptionGroup */
	    foreach ($Product->getConfigurableProductOptionGroups() as $OptionGroup)
	    {
		$index			    = $OptionGroup->hasRequiredOption() ? "required" : "optional";
		$Category		    = $OptionGroup->getConfigurableProductOptionCategory(); 
		$optiongroupcategory_index  = $Category->getIndex();
		
		if(!isset($data[$optiongroupcategory_index]["category"])){
		    $data[$optiongroupcategory_index]["category"] = $Category;
		}
		if(!isset($data[$optiongroupcategory_index]["groups"]["optional"])){
		    $data[$optiongroupcategory_index]["groups"]["optional"] = array();
		}
		if(!isset($data[$optiongroupcategory_index]["groups"]["required"])){
		    $data[$optiongroupcategory_index]["groups"]["required"] = array();
		}
		$data[$optiongroupcategory_index]["groups"][$index][] = $OptionGroup;;
	    }
	    $this->view->quote_id   = $quote_id;
	    $this->view->product_id = $product_id;
	    $this->view->data	    = $data;
	    $this->view->Product    = $Product;
	}
	else{
	    $this->_FlashMessenger->addErrorMessage("There was an error. Please Contact Administrator");
	}
    }
    
    public function getoptionformAction(){
	$group_id   = $this->_request->getParam("group_id", null);
	$Group	    = $this->_em->find("Entities\ConfigurableProductOptionGroup", $group_id);
	/* @var $Group \Entities\ConfigurableProductOptionGroup */
	
	if($Group->getId()){
	    $form = new Form_Quote_ConfigurableProductOptionGroup($Group);
	    $form->removeDecorator('form');
	    echo $form; exit;
	}
    }
    
    public function productaddmanualsaveAction(){
	$this->_helper->layout->setLayout("blank");
	$this->_helper->viewRenderer->setNoRender(true);
	
	$return			    = array();
	$return["success"]	    = true;
	$return["error_message"]    = "";
	$error_message		    = array();
	$values			    = array();
	$quote_id		    = $this->_request->getParam("quote_id");
	$product_id		    = $this->_request->getParam("product_id");
	$QuoteProduct		    = new Entities\QuoteProduct;
	$Quote			    = null;
	$Product		    = null;
	
	if($product_id && $quote_id){	
	    $Quote		= $this->_em->find("Entities\Quote", $quote_id);
	    $Product	= $this->_em->find("Entities\Product", $product_id);
	}
	
	if($Quote && $Product && $this->_request->isPost())
	{
	    $QuoteProduct->setProduct($Product);
	    $data = $this->_request->getPost();
	    foreach($data as $group_id => $group_array){
		$Group			= $this->_em->find("\Entities\ConfigurableProductOptionGroup", $group_id);
		/* @var $Group \Entities\ConfigurableProductOptionGroup */
		$Category		= $Group->getConfigurableProductOptionCategory();
		$required_options_array = $Group->getRequiredOptionIdsArray();
		
		#--Check that all required options exist in post
		foreach ($required_options_array as $option_id) {
		    if(!key_exists($option_id, $group_array)){
			$Option = $this->_em->find("\Entities\ConfigurableProductOption", $option_id);
			$error_message[] = $Category->getName()." - ".$Group->getName().
					    " - ".$Option->getName()." is required.";
		    }
		}
		
		foreach($group_array as $option_id => $value_id)
		{
		    $Option = $this->_em->find("\Entities\ConfigurableProductOption", $option_id);
		    #--Check that required options have a value
		    /* @var $Option \Entities\ConfigurableProductOption */
		    if($Option->isRequired() && !$value_id){
			$error_message[] = $Category->getName()." - ".$Group->getName().
					    " - ".$Option->getName()." is required.";
		    }
		    elseif(!$value_id) {
			
		    }
		    else{
			$Value = $this->_em->find("\Entities\ConfigurableProductOptionValue", $value_id);
			if($Value){
			    $values[] = $Value;
			}
			else{
			    $error_message[] = $Category->getName()." - ".$Group->getName().
					    " - ".$Option->getName()." $value_id is not valid.";
			}
		    }
		}
	    }
	    if(count($error_message)>0){
		$return["success"] = false;
		$return["error_message"] = implode("<br />",$error_message);
	    }
	    else{
		try {
		    foreach ($values as $Value) {
			    $QuoteProductValue = new \Entities\QuoteProductOptionValue;
			    $QuoteProductValue->setConfigurableProductOptionValue($Value);
			    $QuoteProductValue->setQuantity(1);
			    $QuoteProductValue->setNote("");
			    $QuoteProduct->addQuoteProductOptionValue($QuoteProductValue);
		    }
		    $QuoteProduct->setNote("");
		    $QuoteProduct->setPriceEach(0);
		    $QuoteProduct->setQuantity(1);
		    $Quote->addQuoteProduct($QuoteProduct);
		    $this->_em->persist($Quote);
		    $this->_em->flush();
		} catch (Exception $exc) {
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
}

