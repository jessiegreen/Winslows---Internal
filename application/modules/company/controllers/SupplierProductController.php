<?php

/**
 * 
 * @author jessie
 *
 */

class Company_SupplierProductController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/supplier/product.js");
	parent::init();
    }
    
    public function editAction()
    {
	/* @var $Product \Entities\Company\Supplier\Product\ProductAbstract */
	$Product = $this->getEntityFromParamFields('Company\Supplier\Product\ProductAbstract', array("id"));
	
	if(!$Product->getId())
	{
	    $type = $this->_request->getParam("type", null);
	    
	    if(!$type)
	    {
		$this->_FlashMessenger->addErrorMessage("Could not add product. Type not specified.");
		$this->_History->goBack(1);
	    }
	    
	    try 
	    {
		$model_string	= "Entities\Company\Supplier\Product\\".ucfirst(strtolower($type));
		$Product	= new $model_string;
	    } catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack(1);
	    }
	}
	
	switch ($Product->getDescriminator())
	{
	    case "Configurable":
		$Product    = $this->getEntityFromParamFields('Company\Supplier\Product\Configurable', array("id"));
		$form_class = 'Forms\Company\Supplier\Product\Configurable';
		$param_key  = "company_supplier_product_configurable";
	    break;
	    case "Simple":
		$Product    = $this->getEntityFromParamFields("Company\Supplier\Product\Simple", array("id"));
		$form_class = "Forms\Company\Supplier\Product\Simple";
		$param_key  = "company_supplier_product_simple";
	    break;
	    default:
		$this->_FlashMessenger->addErrorMessage("Product Descriminator is Base");
		$this->_History->goBack(1);
	}
	
	$supplier_id	= $this->_request->getParam("supplier_id", 0);
	$Supplier	= $this->_em->find("Entities\Company\Supplier", $supplier_id);
	
	if($supplier_id)$Product->setSupplier ($Supplier);
	
	$form		= new $form_class(array("method" => "post"), $Product);
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params[$param_key];
		
		$Product->populate($data);
		
		/* @var $Supplier \Entities\Company\Supplier */
		$Supplier = $this->_em->find("Entities\Company\Supplier", $data["supplier_id"]);
		
		if(!$Supplier)
		    throw new Exception("Can not add/edit product. No Supplier with that Id");
		
		if(!$Product->getId())
		{
		    $Supplier->addProduct($Product);
		    $this->_em->persist($Supplier);
		}
		else
		{
		    $Product->setSupplier($Supplier);
		    $this->_em->persist($Product);
		}
		
		$this->_em->flush();

		$message = "Product saved";
		$this->_FlashMessenger->addSuccessMessage($message);

	    } 
	    catch (Exception $exc)
	    {
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
	$Product = $this->getEntityFromParamFields("Company\Supplier\Product\ProductAbstract", array("id"));
	
	if(!$Product->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Product");
	    $this->_History->goBack();
	}
	
	$this->view->Product	= $Product;
    }
    
    public function viewallAction()
    {
	$ProductRepos		= $this->_em->getRepository("\Entities\Company\Supplier\Product\ProductAbstract");
	$this->view->Product	= $ProductRepos->findBy(array(), array("name" => "ASC"));
    }
    
    public function manageoptiongroupsAction()
    {
	/* @var $Configurable Entities\Company\Supplier\Product\Configurable */
	$Configurable = $this->getEntityFromParamFields("Company\Supplier\Product\Configurable", array("id"));
	
	if($Configurable)
	{
	    $form = new Forms\Company\Supplier\Product\Configurable\ManageOptions($Configurable, array("method" => "post"));
	    
	    $form->addCancelButton($this->_History->getPreviousUrl(1));
	    
	    if($this->isPostAndValid($form))
	    {
		try 
		{
		    $data	= $this->_params["company_supplier_product_configurable_manageoptions"];
		    $options    = $data["configurable_manageoptions"];

		    foreach ($Configurable->getOptions() as $Option)
		    {
			if(!in_array($Option->getId(), $options))
			{
			    $Configurable->removeOption($Option);
			}

			$current_groups[] = $Option->getId();
		    }

		    foreach ($options as $value) 
		    {
			if(!in_array($value, $current_groups))
			{
			    $Option = $this->_em->find("\Entities\Company\Supplier\Product\Configurable\Option", $value);
			    
			    $Configurable->addOption($Option);
			}
		    }
		    
		    $this->_em->persist($Configurable);
		    $this->_em->flush();
		    
		    $this->_FlashMessenger->addSuccessMessage("Configurable Option saved.");
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
	    $this->_FlashMessenger->addErrorMessage("Could not get Product");
	    $this->_History->goBack();
	}
	
	$this->view->form = $form;
    }
    
    public function manageCategoriesAction()
    {
	/* @var $Product Entities\Company\Supplier\Product\ProductAbstract */
	$Product = $this->getEntityFromParamFields("Company\Supplier\Product\ProductAbstract", array("id"));
	
	if($Product)
	{
	    $form = new Forms\Company\Supplier\Product\ManageCategories($Product, array("method" => "post"));
	    
	    $form->addCancelButton($this->_History->getPreviousUrl(1));
	    
	    if($this->isPostAndValid($form))
	    {
		try 
		{
		    $data		= $this->_request->getParam("company_supplier_product_managecategories", array("product_managecategories" => array()));
		    $categories		= $data["product_managecategories"];
		    $current_categories	= array();

		    foreach ($Product->getCategories() as $Category)
		    {
			if(!in_array($Category->getId(), $categories))
			{
			    $Category->removeProduct($Product);
			    $this->_em->persist($Category);
			}

			$current_categories[] = $Category->getId();
		    }

		    foreach ($categories as $value) 
		    {
			if(!in_array($value, $current_categories))
			{
			    $Category = $this->_em->find("\Entities\Company\Supplier\Product\Category", $value);
			    
			    $Category->addProduct($Product);
			    $this->_em->persist($Category);
			}
		    }
		    
		    $this->_em->flush();
		    
		    $this->_FlashMessenger->addSuccessMessage("Product categories saved.");
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
	    $this->_FlashMessenger->addErrorMessage("Could not get Product");
	    $this->_History->goBack();
	}
	
	$this->view->form = $form;
    }
    
    public function manageDeliveryTypesAction()
    {
	/* @var $Product Entities\Company\Supplier\Product\ProductAbstract */
	$Product = $this->getEntityFromParamFields("Company\Supplier\Product\ProductAbstract", array("id"));
	
	if($Product)
	{
	    $form = new Forms\Company\Supplier\Product\ManageDeliveryTypes($Product, array("method" => "post"));
	    
	    $form->addCancelButton($this->_History->getPreviousUrl());
	    
	    if($this->isPostAndValid($form))
	    {
		try 
		{
		    $data		= $this->_request->getParam(
						"company_supplier_product_managedeliverytypes", 
						array("product_managedeliverytypes" => array())
					    );
		    $delivery_types	= $data["product_managedeliverytypes"];
		    $current_types	= array();

		    $Product->getDeliveryTypes()->clear();
		    
		    foreach ($delivery_types as $value) 
		    {
			$DeliveryType = $this->_em->find("\Entities\Company\Supplier\Product\DeliveryType\DeliveryTypeAbstract", $value);

			if($DeliveryType)
			    $Product->addDeliveryType($DeliveryType);
		    }
		    
		    $this->_em->persist($Product);		    
		    $this->_em->flush();
		    
		    $this->_FlashMessenger->addSuccessMessage("Product delivery types saved.");
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
	    $this->_FlashMessenger->addErrorMessage("Could not get Product");
	    $this->_History->goBack();
	}
	
	$this->view->form = $form;
    }
}

