<?php

/**
 * 
 * @author jessie
 *
 */

class Company_SupplierProductConfigurableOptionParameterValueController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/supplier/product/configurable/option/parameter/value.js");
	parent::init();
    }
    
    public function viewallAction()
    {
	$ValueRepos		= $this->_em->getRepository("Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value");
	$this->view->Values	= $ValueRepos->findBy(array(), array("Parameter_id" => "ASC", "name" => "ASC"));
    }
    
    public function editAction()
    {
	/* @var $Value \Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value */
	$Value = $this->getEntityFromParamFields("Company\Supplier\Product\Configurable\Option\Parameter\Value", array("id"));
	
	$parameter_id	= $this->_request->getParam("parameter_id");
	$new		= !$Value->getId() ? true : false;
	
	if($new && $parameter_id)
	{
	    $Parameter	= $this->_em->find(
				"Entities\Company\Supplier\Product\Configurable\Option\Parameter", 
				$parameter_id
			    );
	    if($Parameter)
	    {
		$Value->setParameter($Parameter);
	    }
	    else{
		$this->_FlashMessenger->addErrorMessage("Could Not Get Parameter");
		$this->_History->goBack();
	    }
	}
	
	$form = new Forms\Company\Supplier\Product\Configurable\Option\Parameter\Value(array("method" => "post"), $Value);
	
	$form->addElement("button", "cancel", 
		    array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["company_supplier_product_configurable_option_parameter_value"];

		$Value->populate($data);
		
		$Parameter = $this->_em->find(
				"Entities\Company\Supplier\Product\Configurable\Option\Parameter", 
				$data["parameter_id"]
			    );
		
		if($Parameter)
		{
		    $Value->setParameter($Parameter);
		    $this->_em->persist($Value);
		    $this->_em->flush();
		}
		else
		{
		    $this->_FlashMessenger->addErrorMessage("Could Not Get Parameter");
		    $this->_History->goBack();
		}

		$message = "Value '".htmlspecialchars($Value->getName())."' saved";
		
		$this->_FlashMessenger->addSuccessMessage($message);
		$this->_History->goBack();
	    }
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->form  = $form;
	$this->view->Value = $Value;
    }
    
    public function deleteAction()
    {
	$this->_helper->viewRenderer->setNoRender(true);
	$this->_helper->layout->disableLayout();
	
	$ACL = new Dataservice_Controller_Plugin_ACL();
	
	$ACL->preDispatch($this->_request);
	
	/* @var $Value \Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value */
	$Value = $this->getEntityFromParamFields("Company\Supplier\Product\Configurable\Option\Parameter\Value", array("id"));
	
	if($Value)
	{
	    try
	    {
		$this->_em->remove($Value);
		$this->_em->flush();
		$this->_FlashMessenger->addSuccessMessage("Value Deleted");
		$this->_History->goBack();
	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	else
	{
	    $this->_FlashMessenger->addErrorMessage("Could Not Get Value");
	    $this->_History->goBack();
	}
    }
}

