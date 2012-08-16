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
	$Instance		    = $this->_getInstance();
	
	$this->_CheckRequiredInstanceExists($Instance);
	
	if($this->_request->isPost())
	{	    
	    $data = $this->_request->getPost();
	    
	    $Instance->removeAllOptions();
	    $this->_em->persist($Instance);
	    
	    foreach($data as $option_array)
	    {
		$parameter_id	    = key($option_array);
		$Parameter	    = $this->_em->find(
					    "\Entities\Company\Supplier\Product\Configurable\Option\Parameter", 
					    $parameter_id
					);
		$ConfigurableOption = $Parameter->getOption();
		$Option		    = new \Entities\Company\Supplier\Product\Configurable\Instance\Option($ConfigurableOption);
		
		/* @var $ConfigurableOption \Entities\Company\Supplier\Product\Configurable\Option */
		$Category		= $ConfigurableOption->getCategory();
		$required_parameters	= $ConfigurableOption->getRequiredParameters();
		$required_message	= $Category->getName()." - ".$ConfigurableOption->getName()." - %s is required.";
		
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
			
			if($Value)$Option->addValue($Value);
			else $error_message[] = $Category->getName()." - ".$ConfigurableOption->getName().
					    " - ".$Parameter->getName()." $value_id is not valid.";
		    }
		    
		}
		$Instance->addOption($Option);
	    }
	    if(count($error_message)>0){
		$return["success"] = false;
		$return["error_message"] = implode("<br />",$error_message);
	    }
	    else{
		try 
		{		    
		    $Instance->setNote($Instance->getNote()." **".date("Y-m-d H:i:s")." Modified");
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
	$this->view->headScript()->appendFile("/javascript/company/supplier/product/configurable/instance/manual.js");
	$this->view->headLink()->prependStylesheet('/css/jquery-ui/flick/jquery-ui.custom.css');
	
	$Instance	= $this->_getInstance();
	$data		= array();
	
	$this->_CheckRequiredInstanceExists($Instance);
	
	$left	    = array();
	$required   = array();
	
	#--Build Left Options Array and required array
	/* @var $Option \Entities\Company\Supplier\Product\Configurable\Option */
	foreach ($Instance->getProduct()->getOptions() as $Option)
	{
	    $Category = $Option->getCategory();
	    
	    $left[$Category->getIndex()]["category"] = array(
							    "name"  => $Category->getName(), 
							    "id"    => $Category->getId(), 
							    "index" => $Category->getIndex()
							    );
	    $left[$Category->getIndex()]["options"][$Option->getId()] = array(
									"name"	    => $Option->getName(), 
									"id"	    => $Option->getId(), 
									"index"	    => $Option->getIndex(),
									"maxcount"  => $Option->getMaxCount()
									);
	    if($Option->hasRequiredOption())$required[] = $Option->getId();
	}
	
	$data["left"]	    = $left;
	$data["required"]   = $required;
	
	$existing = array();
	
	#--Build Existing Array
	/* @var $Option \Entities\Company\Supplier\Product\Configurable\Instance\Option */
	foreach ($Instance->getOptions() as $Option)
	{
	    $ConfigurableOption			= $Option->getOption();
	    $Category				= $ConfigurableOption->getCategory(); 
	    $temp_array				= array();
	    $temp_array["category"]		= array(
							"name"  => $Category->getName(), 
							"id"    => $Category->getId(), 
							"index" => $Category->getIndex()
						    );
	    $temp_array["instance_option"]	= array(
							"id" => $Option->getId()
						    );
	    $temp_array["configurable_option"]  = array(
							"id" => $ConfigurableOption->getId()
						    );
	    $existing[]				= $temp_array;
	}
	
	$data["existing"] = $existing;
	
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
	$Option		    = $this->_getOption();
	$ConfigurableOption = $this->_getConfigurableOption();
	
	$this->_CheckRequiredConfigurableOptionExists($ConfigurableOption);
	
	if(!$Option)$Option = new Entities\Company\Supplier\Product\Configurable\Instance\Option($ConfigurableOption);
	
	$form	= new Forms\Company\Supplier\Product\Configurable\Instance\Manual\Option($ConfigurableOption, $Option);
	
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
    private function _getConfigurableOption()
    {
	$id = $this->_request->getParam("configurable_option_id", 0);
	return $this->_em->find("Entities\Company\Supplier\Product\Configurable\Option", $id);
    }
    
    private function _CheckRequiredConfigurableOptionExists(Entities\Company\Supplier\Product\Configurable\Option $Option)
    {
	if(!$Option->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Option");
	    $this->_History->goBack();
	}
    }
    
    /**
     * @return Entities\Company\Supplier\Product\Configurable\Option
     */
    private function _getOption()
    {
	$id = $this->_request->getParam("option_id", 0);
	return $this->_em->find("Entities\Company\Supplier\Product\Configurable\Instance\Option", $id);
    }
    
    private function _CheckRequiredOptionExists(Entities\Company\Supplier\Product\Configurable\Instance\Option $Option)
    {
	if(!$Option->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Option");
	    $this->_History->goBack();
	}
    }
}

