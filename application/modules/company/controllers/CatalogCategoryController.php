<?php
class Company_CatalogCategoryController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Catalog\Category";
	
	parent::init();
    }
    
    public function manageProductsAction()
    {
	$this->_requireEntity();
	
	$form = new Forms\Company\Catalog\Category\ManageProducts($this->_Entity, array("method" => "post"));

	$form->addCancelButton($this->_History->getPreviousUrl());

	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data			= $this->_getParam("company_catalog_category_manage_products");
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
}

