<?php

/**
 * 
 * @author jessie
 *
 */

class Company_SupplierProductConfigurableOptionParameterController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/supplier/product/configurable/option/parameter.js");
	parent::init();
    }
    
    public function preDispatch()
    {
	parent::preDispatch();
    }
    
    public function viewAction()
    {
	$Parameter = $this->getEntityFromParamFields("Company\Supplier\Product\Configurable\Option\Parameter", array("id"));
	
	if(!$Parameter->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Parameter");
	    $this->_History->goBack();
	}
	
	$this->view->Parameter	= $Parameter;
    }
    
    public function viewallAction()
    {
	$ParameterRepos		= $this->_em->getRepository("Entities\Company\Supplier\Product\Configurable\Option\Parameter");
	$this->view->Parameters	= $ParameterRepos->findBy(array(), array("name" => "ASC"));
    }
    
    public function editAction()
    {
	/* @var $Parameter \Entities\Company\Supplier\Product\Configurable\Option\Parameter */ 
	$Parameter  = $this->getEntityFromParamFields("Company\Supplier\Product\Configurable\Option\Parameter", array("id"));
	$option_id  = $this->_request->getParam("option_id");
	$new	    = !$Parameter->getId() ? true : false;
	
	if($new && $option_id)
	{
	    $Option = $this->_em->find(
			    "Entities\Company\Supplier\Product\Configurable\Option", 
			    $option_id
			);
	    
	    $Parameter->setOption($Option);
	}
	
	$form = new Forms\Company\Supplier\Product\Configurable\Option\Parameter(array("method" => "post"), $Parameter);
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["company_supplier_product_configurable_option_parameter"];
		$Option = $this->_em->find(
				"Entities\Company\Supplier\Product\Configurable\Option", 
				$data["option_id"]
			    );

		$Parameter->populate($data);
		
		if($Option)
		{
		    $Parameter->setOption($Option);
		    $this->_em->persist($Parameter);
		    $this->_em->flush();
		}
		else
		{
		    $this->_FlashMessenger->addErrorMessage("Could Not Get Option");
		    $this->_History->goBack();
		}

		$message = "Parameter '".htmlspecialchars($Parameter->getName())."' saved";
		
		$this->_FlashMessenger->addSuccessMessage($message);
		$this->_History->goBack();
	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->form	= $form;
	$this->view->Parameter	= $Parameter;
    }
    
    public function deleteAction()
    {
	$this->_helper->viewRenderer->setNoRender(true);
	$this->_helper->layout->disableLayout();
	
	$ACL = new Dataservice_Controller_Plugin_ACL();
	
	$ACL->preDispatch($this->_request);
	
	/* @var $Parameter \Entities\Company\Supplier\Product\Configurable\Option\Parameter */
	$Parameter = $this->getEntityFromParamFields("Company\Supplier\Product\Configurable\Option\Parameter", array("id"));

	if($Parameter->getId())
	{
	    try 
	    {
		$this->_em->remove($Parameter);
		$this->_em->flush();
		
		$this->_FlashMessenger->addSuccessMessage("Parameter Deleted");
		$this->_History->goBack();
	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	else{
	    $this->_FlashMessenger->addErrorMessage("Could Not Get Parameter");
	    $this->_History->goBack();
	}
    }
}

