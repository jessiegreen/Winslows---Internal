<?php

/**
 * 
 * @author jessie
 *
 */

class Company_SupplierProductPurposeController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/supplier/product/purpose.js");
	
	parent::init();
    }
    
    public function editAction()
    {
	/* @var $Purpose \Entities\Company\Supplier\Product\Purpose */
	$Purpose    = $this->getEntityFromParamFields('Company\Supplier\Product\Purpose', array("id"));
	$product_id = $this->_request->getParam("product_id"); 
	
	if(!$Purpose->getId())
	{	    
	    if($product_id)
	    {
		$Product = $this->_em->getRepository("Entities\Company\Supplier\Product\ProductAbstract")->find($product_id);
		if(!$Product)
		{
		    $this->_FlashMessenger->addErrorMessage("Could not get Product.");
		    $this->_History->goBack();
		}
		
		$Purpose->setProduct($Product);
	    } 
	    else
	    {
		$this->_FlashMessenger->addErrorMessage("Could not get Product Id.");
		$this->_History->goBack();
	    }
	}
	
	$form = new Forms\Company\Supplier\Product\Purpose($Purpose, array("method" => "post"));
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["company_supplier_product_purpose"];
		
		$Purpose->populate($data);
		
		/* @var $Product Entities\Company\Supplier\Product\ProductAbstract */
		$Product = $this->_em->getRepository("Entities\Company\Supplier\Product\ProductAbstract")->find($data["product_id"]);
		
		if(!$Product)
		{
		    $this->_FlashMessenger->addErrorMessage("Could not get Product.");
		    $this->_History->goBack();
		}
		
		$Purpose->setProduct($Product);
		
		$this->_em->persist($Purpose);
		$this->_em->flush();

		$message = "Purpose saved";
		$this->_FlashMessenger->addSuccessMessage($message);

	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	    
	    $this->_History->goBack();
	}
	
	$this->view->form	= $form;
	$this->view->Purpose	= $Purpose;
    }
}

