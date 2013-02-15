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
    
    public function manageCatalogsAction()
    {
	$this->_requireEntity();
	
	$form = new Forms\Company\Supplier\Product\ManageCatalogs($this->_Entity, array("method" => "post"));

	$form->addCancelButton($this->_History->getPreviousUrl());

	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$post_data		= $this->_request->getPost();
		$data			= $post_data["company_supplier_product_manage_catalogs"];
		$catalogs		= $data["catalogs"];
		$current_catalogs	= array();

		foreach ($this->_Entity->getCatalogs() as $Catalog)
		{
		    if(!in_array($Catalog->getId(), $catalogs))
		    {
			$Catalog->removeProduct($this->_Entity);
			$this->_em->persist($Catalog);
		    }

		    $current_catalogs[] = $Catalog->getId();
		}

		foreach ($catalogs as $value) 
		{
		    if(!in_array($value, $current_catalogs))
		    {
			$Catalog = $this->_em->find("\Entities\Company\Catalog", $value);

			$Catalog->addProduct($this->_Entity);
			    
			$this->_em->persist($Catalog);
		    }
		}

		$this->_em->flush();

		$this->_FlashMessenger->addSuccessMessage("Product catalogs saved.");
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
    
    public function setDefaultImageAction()
    {
	$this->_requireEntity();
	
	$form = new Forms\Company\Supplier\Product\SetDefaultImage($this->_Entity, array("method" => "post"));
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    $post	= $this->_request->getPost();
	    $data	= $post["company_supplier_product_set_default_image"];
	    $image_id	= $data["default_image"];
	    
	    $Image = $this->_em->find("Entities\Company\Supplier\Product\File\Image", $image_id);
	    
	    if($Image)
	    {
		$this->_Entity->setDefaultImage($Image);
		
		$this->_em->persist($this->_Entity);
		$this->_em->flush();
		
		$this->_FlashMessenger->addSuccessMessage("Default Image Set");
	    }
	    else $this->_FlashMessenger->addErrorMessage ("Could not get Image");
	    
	    $this->_History->goBack();
	}
	
	$this->view->form = $form;
    }
}