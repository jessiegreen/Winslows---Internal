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
	$RtoProvider = $this->getEntityFromParamFields("RtoProvider", array("id"));
	
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
	else{
	    $this->_FlashMessenger->addErrorMessage("Could not get RtoProvider");
	    $this->_History->goBack();
	}
	
	$this->view->form = $form;
    }
    
    public function viewAction()
    {
	$RtoProvider = $this->getEntityFromParamFields("RtoProvider", array("id"));
	
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
	$RtoProvider	= $this->getEntityFromParamFields("RtoProvider", array("id"));
	$form		= new Forms\RtoProvider(array("method" => "post"), $RtoProvider);
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$rto_provider_data	= $this->_params["rto_provider"];

		$RtoProvider->populate($rto_provider_data);
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

