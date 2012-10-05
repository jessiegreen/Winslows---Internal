<?php

/**
 * 
 * @author jessie
 *
 */

class Company_RtoProviderProgramController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/rto-provider/program.js");
	
	parent::init();
    }
    
    public function editAction()
    {
	$Program	    = $this->getEntityFromParamFields("Company\RtoProvider\Program", array("id"));
	$rto_provider_id    = $this->_request->getParam("rto_provider_id");
	
	if(!$Program->getId() && $rto_provider_id)
	{
	    $RtoProvider = $this->_em->getRepository("Entities\Company\RtoProvider")->find($rto_provider_id);

	    if($RtoProvider)
	    {
		$Program->setRtoProvider($RtoProvider);
	    }
	}
	
	$form = new Forms\Company\RtoProvider\Program($Program, array("method" => "post"));
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$program_data	= $this->_params["company_rto_provider_program"];

		$Program->populate($program_data);
		
		if($program_data["rto_provider_id"])
		{
		    $RtoProvider = $this->_em->getRepository("Entities\Company\RtoProvider")->find($program_data["rto_provider_id"]);
		    
		    if($RtoProvider)
		    {
			$Program->setRtoProvider($RtoProvider);
		    }
		}
		
		$this->_em->persist($Program);
		$this->_em->flush();

		$message = "Program '".htmlspecialchars($Program->getName())."' saved";
		
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
	$this->view->Program	= $Program;
    }
    
    public function manageProductsAction()
    {
	/* @var $Program Entities\Company\RtoProvider\Program */
	$Program	= $this->getEntityFromParamFields("Company\RtoProvider\Program", array("id"));
	
	if($Program)
	{	    
	    $form = new Forms\Company\RtoProvider\Program\ManageProducts($Program, array("method" => "post"));
	    
	    $form->addCancelButton($this->_History->getPreviousUrl(1));
	    
	    if($this->isPostAndValid($form))
	    {
		try 
		{
		    $data		= $this->_params["company_rto_provider_program_manageproducts"];
		    $products		= $data["products_checks"];
		    $current_products	= array();
		    
		    foreach ($Program->getProducts() as $Product)
		    {
			if(!in_array($Product->getId(), $products))
			{
			    $Program->removeProduct($Product);
			}

			$current_products[] = $Product->getId();
		    }

		    foreach ($products as $product) 
		    {
			if(!in_array($product, $current_products))
			{
			    $Product = $this->_em->find("\Entities\Company\Supplier\Product\ProductAbstract", $product);
			    $Program->addProduct($Product);
			}
		    }
		    
		    $this->_em->persist($Program);
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
	    $this->_FlashMessenger->addErrorMessage("Could not get Program");
	    $this->_History->goBack();
	}
	
	$this->view->form = $form;
    }
    
    public function viewAction()
    {
	$Program = $this->getEntityFromParamFields("Company\RtoProvider\Program", array("id"));
	
	if(!$Program->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Program");
	    $this->_History->goBack();
	}
	
	$this->view->Program	= $Program;
    }
}

