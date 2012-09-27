<?php

/**
 * 
 * @author jessie
 *
 */

class Company_RtoProviderController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/rto_provider.js");
	
	parent::init();
    }
    
    public function manageProductsAction()
    {
	/* @var $RtoProvider Entities\Company\RtoProvider */
	$RtoProvider	= $this->getEntityFromParamFields("Company\RtoProvider", array("id"));
	
	if($RtoProvider)
	{	    
	    $form = new Forms\RtoProvider\ManageProducts($RtoProvider, array("method" => "post"));
	    
	    $form->addCancelButton($this->_History->getPreviousUrl(1));
	    
	    if($this->isPostAndValid($form))
	    {
		try 
		{
		    $data		= $this->_params["rto_provider_manageproducts"];
		    $products		= $data["products_checks"];
		    $current_products	= array();
		    
		    foreach ($RtoProvider->getProducts() as $Product)
		    {
			if(!in_array($Product->getId(), $products)){
			    $RtoProvider->removeProduct($Product);
			}

			$current_products[] = $Product->getId();
		    }

		    foreach ($products as $product) 
		    {
			if(!in_array($product, $current_products))
			{
			    $Product = $this->_em->find("\Entities\Company\Supplier\Product\ProductAbstract", $product);
			    $RtoProvider->addProduct($Product);
			}
		    }
		    
		    $this->_em->persist($RtoProvider);
		    $this->_em->flush();
		    $this->_FlashMessenger->addSuccessMessage("Product saved.");
		    $this->_History->goBack();
		}
		catch (Exception $exc)
		{
		    $this->_FlashMessenger->addErrorMessage($exc->getMessage());
		    $this->_History->goBack();
		}
	    }
	}
	else
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get RtoProvider");
	    $this->_History->goBack();
	}
	
	$this->view->form = $form;
    }
    
    public function viewAction()
    {
	$RtoProvider = $this->getEntityFromParamFields("Company\RtoProvider", array("id"));
	
	if(!$RtoProvider->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get RtoProvider");
	    $this->_History->goBack();
	}
	
	$this->view->RtoProvider	= $RtoProvider;
    }
    
    public function viewAllAction()
    {
	$RtoProviders		    = $this->_em->getRepository("Entities\Company\RtoProvider")->findAll();
	$this->view->RtoProviders   = $RtoProviders;
    }
    
    public function editAction()
    {
	$RtoProvider	= $this->getEntityFromParamFields("Company\RtoProvider", array("id"));
	$company_id	= $this->_request->getParam("company_id");
	
	if(!$RtoProvider->getId() && $company_id)
	{
	    $Company = $this->_em->getRepository("Entities\Company")->find($company_id);

	    if($Company)
	    {
		$RtoProvider->setCompany($Company);
	    }
	}
	
	$form = new Forms\RtoProvider(array("method" => "post"), $RtoProvider);
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$rto_provider_data	= $this->_params["company_rto_provider"];

		$RtoProvider->populate($rto_provider_data);
		
		if($rto_provider_data["company_id"])
		{
		    $Company = $this->_em->getRepository("Entities\Company")->find($rto_provider_data["company_id"]);
		    
		    if($Company)
		    {
			$RtoProvider->setCompany($Company);
		    }
		}
		
		$this->_em->persist($RtoProvider);
		$this->_em->flush();

		$message = "RtoProvider '".htmlspecialchars($RtoProvider->getName())."' saved";
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
	$this->view->RtoProvider	= $RtoProvider;
    }
}

