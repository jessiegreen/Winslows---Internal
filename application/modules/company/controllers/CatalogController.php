<?php
class Company_CatalogController extends Dataservice_Controller_Crud_Action
{    
    public function init() 
    {
	$this->_EntityClass = "Entities\Company\Catalog";
	
	parent::init();
    }
    
    public function manageProductsAction()
    {
	$this->_requireEntity();
	
	$form = new Forms\Company\Catalog\ManageProducts($this->_Entity, array("method" => "post"));

	$form->addCancelButton($this->_History->getPreviousUrl());

	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data			= $this->_getParam("company_catalog_manage_products");
		$products		= $data["products"];
		$current_products	= array();

		foreach ($this->_Entity->getProducts() as $Product)
		{
		    if(!in_array($Product->getId(), $products))
		    {
			$this->_Entity->removeProduct($Product);
		    }

		    $current_products[] = $Product->getId();
		}

		foreach ($products as $product) 
		{
		    if(!in_array($product, $current_products))
		    {
			$Product = $this->_em->find("\Entities\Company\Supplier\Product\ProductAbstract", $product);
			
			$this->_Entity->addProduct($Product);
		    }
		}

		$this->_em->persist($this->_Entity);
		$this->_em->flush();
		
		$this->_FlashMessenger->addSuccessMessage("Products saved.");
	    }
	    catch (\Exception $exc)
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
	
	$form = new Forms\Company\Catalog\ManageWebsites($this->_Entity, array("method" => "post"));

	$form->addCancelButton($this->_History->getPreviousUrl());

	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data			= $this->_getParam("company_catalog_manage_websites");
		$websites		= $data["websites"];
		$current_websites	= array();

		foreach ($this->_Entity->getWebsites() as $Website)
		{
		    if(!in_array($Website->getId(), $websites))
		    {
			$this->_Entity->removeWebsite($Website);
		    }

		    $current_websites[] = $Website->getId();
		}

		foreach ($websites as $website) 
		{
		    if(!in_array($website, $current_websites))
		    {
			$Website = $this->_em->find("\Entities\Company\Website", $website);
			
			$this->_Entity->addWebsite($Website);
		    }
		}

		$this->_em->persist($this->_Entity);
		$this->_em->flush();
		
		$this->_FlashMessenger->addSuccessMessage("Websites saved.");
	    }
	    catch (\Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    }
	    
	    $this->_History->goBack();
	}
	
	$this->view->form = $form;
    }
}

