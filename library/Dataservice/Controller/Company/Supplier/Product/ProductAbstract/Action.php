<?php
class Dataservice_Controller_Company_Supplier_Product_ProductAbstract_Action extends Dataservice_Controller_Crud_Action
{    
    public function manageCategoriesAction()
    {
	$this->_requireEntity();
	
	$form = new Forms\Company\Supplier\Product\ManageCategories($this->_Entity, array("method" => "post"));

	$form->addCancelButton($this->_History->getPreviousUrl());

	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data			= $this->getRequest()->getParam("company_supplier_product_managecategories", array("product_managecategories" => array()));
		$categories		= $data["product_managecategories"];
		$current_categories	= array();

		foreach ($this->_Entity->getCategories() as $Category)
		{
		    if(!in_array($Category->getId(), $categories))
		    {
			$Category->removeProduct($this->_Entity);
			$this->_em->persist($Category);
		    }

		    $current_categories[] = $Category->getId();
		}

		foreach ($categories as $value) 
		{
		    if(!in_array($value, $current_categories))
		    {
			$Category = $this->_em->find("\Entities\Company\Supplier\Product\Category", $value);

			$Category->addProduct($this->_Entity);
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
	
	$this->view->form = $form;
    }
    
    public function manageDeliveryTypesAction()
    {
	$this->_requireEntity();
	
	$form = new Forms\Company\Supplier\Product\ManageDeliveryTypes($this->_Entity, array("method" => "post"));

	$form->addCancelButton($this->_History->getPreviousUrl());

	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data		= $this->getRequest()->getParam(
					    "company_supplier_product_managedeliverytypes", 
					    array("product_managedeliverytypes" => array())
					);
		$delivery_types	= $data["product_managedeliverytypes"];

		$this->_Entity->getDeliveryTypes()->clear();

		foreach ($delivery_types as $value) 
		{
		    $DeliveryType = $this->_em->find("\Entities\Company\Supplier\Product\DeliveryType\DeliveryTypeAbstract", $value);

		    if($DeliveryType)
			$this->_Entity->addDeliveryType($DeliveryType);
		}

		$this->_em->persist($this->_Entity);		    
		$this->_em->flush();

		$this->_FlashMessenger->addSuccessMessage("Product delivery types saved.");
	    }
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    }
	    
	    $this->_History->goBack();
	}
	
	$this->view->form = $form;
    }
    
    public function manageWebsitesAction()
    {
	$this->_requireEntity();
	
	$form = new Forms\Company\Supplier\Product\ManageWebsites($this->_Entity, array("method" => "post"));

	$form->addCancelButton($this->_History->getPreviousUrl());

	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$post_data		= $this->_request->getPost();
		$data			= $post_data["company_supplier_product_manage_websites"];
		$websites		= $data["websites"];
		$current_websites	= array();

		foreach ($this->_Entity->getWebsites() as $Website)
		{
		    if(!in_array($Website->getId(), $websites))
		    {
			$Website->removeProduct($this->_Entity);
			$this->_em->persist($Website);
		    }

		    $current_websites[] = $Website->getId();
		}

		foreach ($websites as $value) 
		{
		    if(!in_array($value, $current_websites))
		    {
			$Website = $this->_em->find("\Entities\Company\Website", $value);

			$Website->addProduct($this->_Entity);
			    
			$this->_em->persist($Website);
		    }
		}

		$this->_em->flush();

		$this->_FlashMessenger->addSuccessMessage("Product websites saved.");
		$this->_History->goBack();
	    }
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->form = $form;
    }
}