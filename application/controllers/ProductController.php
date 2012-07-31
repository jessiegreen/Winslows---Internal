<?php

/**
 * 
 * @author jessie
 *
 */

class ProductController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/product/product.js");
	parent::init();
    }
    
    public function editAction()
    {
	/* @var $Product \Entities\Product */
	$Product	= $this->getEntityFromParamFields("Product", array("id"));
	switch ($Product->getDescriminator()) {
	    case "Configurable":
		$Product    = $this->getEntityFromParamFields("ConfigurableProduct", array("id"));
		$form_class = "Form_ConfigurableProduct";
		$param_key  = "configurableproduct";
	    break;
	    case "Simple":
		$Product    = $this->getEntityFromParamFields("SimpleProduct", array("id"));
		$form_class = "Form_SimpleProduct";
		$param_key  = "simpleproduct";
	    break;
	    default:
		$this->_FlashMessenger->addErrorMessage("Product Descriminator is Base");
		$this->_History->goBack(1);
	}
	
	$supplier_id	= $this->_request->getParam("supplier_id", 0);
	$Supplier	= $this->_em->find("Entities\Supplier", $supplier_id);
	
	if($supplier_id)$Product->setSupplier ($Supplier);
	
	$form		= new $form_class(array("method" => "post"), $Product);
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$data	= $this->_params[$param_key];
		
		$Product->populate($data);
		/* @var $Supplier \Entities\Supplier */
		$Supplier = $this->_em->find("Entities\Supplier", $data["supplier_id"]);
		if(!$Supplier)
		    throw new Exception("Can not add/edit product. No Supplier with that Id");
		
		if(!$Product->getId()){
		    $Supplier->addProduct($Product);
		    $this->_em->persist($Supplier);
		}
		else{
		    $Product->setSupplier($Supplier);
		    $this->_em->persist($Product);
		}
		
		$this->_em->flush();

		$message = "Product saved";
		$this->_FlashMessenger->addSuccessMessage($message);

	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack(1);
	    }
	    $this->_History->goBack(1);
	}
	
	$this->view->form	= $form;
	$this->view->Product	= $Product;
    }
    
    public function viewAction()
    {
	$Product = $this->getEntityFromParamFields("Product", array("id"));
	
	if(!$Product->getId()){
	    $this->_FlashMessenger->addErrorMessage("Could not get Product");
	    $this->_History->goBack();
	}
	
	$this->view->Product	= $Product;
    }
    
    public function viewallAction()
    {
	$ProductRepos		= $this->_em->getRepository("Entities\Product");
	$this->view->Product	= $ProductRepos->findBy(array(), array("name" => "ASC"));
    }
    
    public function manageoptiongroupsAction(){
	/* @var $ConfigurableProduct \Entities\ConfigurableProduct */
	$ConfigurableProduct = $this->getEntityFromParamFields("ConfigurableProduct", array("id"));
	
	if($ConfigurableProduct){
	    $form = new Form_ConfigurableProduct_ManageOptions($ConfigurableProduct, array("method" => "post"));
	    $form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	    
	    if($this->isPostAndValid($form)){
		try {
		    $data	= $this->_params["product_manageoptions"];
		    $options    = $data["configurableproduct_manageoptions"];

		    foreach ($ConfigurableProduct->getConfigurableProductOptionGroups() as $ConfigurableProductOptionGroup) {
			if(!in_array($ConfigurableProductOptionGroup->getId(), $options)){
			    $ConfigurableProduct->removeConfigurableProductOptionGroup($ConfigurableProductOptionGroup);
			}

			$current_groups[] = $ConfigurableProductOptionGroup->getId();
		    }

		    foreach ($options as $value) {
			if(!in_array($value, $current_groups)){
			    $ConfigurableProductOptionGroup = $this->_em->find("Entities\ConfigurableProductOptionGroup", $value);
			    $ConfigurableProduct->addConfigurableProductOptionGroup($ConfigurableProductOptionGroup);
			}
		    }

		    $this->_em->persist($ConfigurableProduct);
		    $this->_em->flush();
		    $this->_FlashMessenger->addSuccessMessage("Configurable Option Groups saved.");
		    $this->_History->goBack();
		}
		catch (Exception $exc) {
		    $this->_FlashMessenger->addErrorMessage($exc->getMessage());
		    $this->_History->goBack();
		}
	    }
	}
	else{
	    $this->_FlashMessenger->addErrorMessage("Could not get Product");
	    $this->_History->goBack();
	}
	
	$this->view->form = $form;
    }
}

