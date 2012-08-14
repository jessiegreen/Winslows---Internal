<?php

class Company_SupplierProductConfigurableInstanceController extends Dataservice_Controller_Action
{     
    public function manualsaveajaxAction()
    {
	$this->_helper->layout->setLayout("blank");
	$this->_helper->viewRenderer->setNoRender(true);
	
	$return			    = array();
	$return["success"]	    = true;
	$return["error_message"]    = "";
	$error_message		    = array();
	$values			    = array();
	$Instance		    = $this->_getInstance();
	
	$this->_CheckRequiredInstanceExists($Instance);
	
	if($this->_request->isPost())
	{	    
	    $data = $this->_request->getPost();
	    
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
		try 
		{
		    $Instance->removeAllValues();
		    
		    foreach ($values as $Value)
		    {
			$Instance->addValue($Value);
		    }
		    
		    $Instance->setNote("");
		    $this->_em->persist($Instance);
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
    
    public function manualAction()
    {	
	$this->view->headScript()->appendFile("/javascript/jquery/jquery-ui.min.js");
	$this->view->headLink()->prependStylesheet('/css/jquery-ui/flick/jquery-ui.custom.css');
	
	$Instance	= $this->_getInstance();
	$InstanceValues	= $Instance->getValues();
	$data		= array();
	
	$this->_CheckRequiredInstanceExists($Instance);
	
	/* @var $Option \Entities\Company\Supplier\Product\Configurable\Option */
	foreach ($Instance->getProduct()->getOptions() as $Option)
	{
	    $index = "optional";
	    
	    if($Option->hasRequiredOption()) $index = "required";
	    else
	    {
		foreach ($Option->getParameters() as $Parameter) {
		    foreach ($Parameter->getValues() as $Value)
		    {
			if($InstanceValues->contains($Value))
			{
			    $index = "existing";
			}
		    }
		}
	    }
	    
	    $Category	    = $Option->getCategory(); 
	    $category_index = $Category->getIndex();

	    if(!isset($data[$category_index]["category"]))
		$data[$category_index]["category"] = $Category;
	    
	    if(!isset($data[$category_index]["options"]["optional"]))
		$data[$category_index]["options"]["optional"] = array();
	    
	    if(!isset($data[$category_index]["options"]["required"]))
		$data[$category_index]["options"]["required"] = array();
	    
	    if(!isset($data[$category_index]["options"]["existing"]))
		$data[$category_index]["options"]["existing"] = array();
	    
	    $data[$category_index]["options"][$index][] = $Option;
	}
	
	$this->view->Instance	= $Instance;
	$this->view->data	= $data;
	$this->view->return_url	= $this->_History->getPreviousUrl();
    }
    
    public function chooseeditorajaxAction()
    {
	$this->_helper->layout->setLayout("blank");
	
	$Instance = $this->_getInstance();

	$this->_CheckRequiredInstanceExists($Instance);
	
	$this->view->form	= new Forms\Company\Lead\Quote\AddProduct2(
					array("id" => "quote_addproduct2", "name" => "quote_addproduct2")
				    );
	$this->view->Instance	= $Instance;
    }
    
    public function getoptionformAction()
    {
	$Option	    = $this->_getOption();
	$Instance   = $this->_getInstance();
	
	$this->_CheckRequiredOptionExists($Option);
	
	$form	= new Forms\Company\Supplier\Product\Configurable\Instance\Option($Instance, $Option);
	
	$form->removeDecorator('form');
	
	echo $form; exit;
    }
    
    /**
     * @return Entities\Company\Supplier\Product\Configurable\Instance
     */
    private function _getInstance()
    {
	return $this->getEntityFromParamFields("Company\Supplier\Product\Configurable\Instance", array("id"));
    }
    
    private function _CheckRequiredInstanceExists(\Entities\Company\Supplier\Product\Configurable\Instance $Instance)
    {
	if(!$Instance->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Instance");
	    $this->_History->goBack();
	}
    }    
    
    /**
     * @return Entities\Company\Supplier\Product\Configurable\Option
     */
    private function _getOption()
    {
	$id = $this->_request->getParam("option_id", 0);
	return $this->_em->find("Entities\Company\Supplier\Product\Configurable\Option", $id);
    }
    
    private function _CheckRequiredOptionExists(Entities\Company\Supplier\Product\Configurable\Option $Option)
    {
	if(!$Option->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Option");
	    $this->_History->goBack();
	}
    }
}

