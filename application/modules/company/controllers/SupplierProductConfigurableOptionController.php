<?php

/**
 * 
 * @author jessie
 *
 */

class Company_SupplierProductConfigurableOptionController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/supplier/product/configurable/option.js");
	
	parent::init();
    }
    
    public function viewAction()
    {
	$Option = $this->getEntityFromParamFields("Company\Supplier\Product\Configurable\Option", array("id"));
	
	if(!$Option->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Option");
	    $this->_History->goBack();
	}
	
	$this->view->Option	= $Option;
    }
    
    public function viewallAction()
    {
	$OptionRepos		= $this->_em->getRepository("Entities\Company\Supplier\Product\Configurable\Option");
	$this->view->Options	= $OptionRepos->findAll();
    }
    
    public function editAction()
    {
	$Option	    = $this->getEntityFromParamFields("Company\Supplier\Product\Configurable\Option", array("id"));
	$form	    = new Forms\Company\Supplier\Product\Configurable\Option(array("method" => "post"), $Option);
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data = $this->_params["company_supplier_product_configurable_option"];

		$Option->populate($data);
		
		if($data["category_id"])
		{
		    $Category = $this->_em->getRepository("Entities\Company\Supplier\Product\Configurable\Option\Category")->find($data["category_id"]);
		    
		    if($Category)
		    {
			$Option->setCategory($Category);
		    }
		    else
		    {
			$this->_FlashMessenger->addErrorMessage("Could not get Category");
			$this->_History->goBack();
		    }
		}
		else
		{
		    $this->_FlashMessenger->addErrorMessage("Could not get Category Id");
		    $this->_History->goBack();
		}
		
		$configurable_id = $this->_request->getParam("configurableproduct_id");
		
		if(!$Option->getId() && $configurable_id)
		{
		    $Configurable = $this->_em->find("Entities\Company\Supplier\Product\Configurable", $configurable_id);
		    
		    if($Configurable)
		    {
			$Configurable->addOption($Option);
			$this->_em->persist($Configurable);
			$this->_em->flush();
		    }
		}
		else
		{
		    $this->_em->persist($Option);
		    $this->_em->flush();
		}

		$message = "Configurable Product Option'".htmlspecialchars($Option->getName())."' saved";
		
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
	$this->view->Option	= $Option;
    }
    
    public function deleteAction()
    {
	$this->_helper->viewRenderer->setNoRender(true);
	$this->_helper->layout->disableLayout();
	
	/* @var $Option \Entities\Company\Supplier\Product\Configurable\Option */
	$Option = $this->getEntityFromParamFields("Company\Supplier\Product\Configurable\Option", array("id"));

	if($Option->getId())
	{
	    try 
	    {
		$this->_em->remove($Option);
		$this->_em->flush();
		$this->_FlashMessenger->addSuccessMessage("Configurable Product Option Deleted");
		$this->_History->goBack();
	    } catch (Exception $exc) 
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	else
	{
	    $this->_FlashMessenger->addErrorMessage("Could Not Get Configurable Product Option");
	    $this->_History->goBack();
	}
    }
}

