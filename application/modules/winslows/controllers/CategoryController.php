<?php
class Winslows_CategoryController extends Dataservice_Controller_Action
{
    public function viewAction()
    {
	
	$category_index = $this->_getParam("category_index");
	
	if($category_index)
	{
	    $Company = $this->_Website->getCompany();
	    
	    $Category = $Company->getCatalogCategoryByIndex($category_index);
	    
	    if(!$Category)
	    {
		$this->_FlashMessenger->addErrorMessage("Category does not exist");
		$this->_History->goBack();
	    }
	}
	
	$this->view->headTitle()->append($Category->getName());
	    
	$this->view->Category = $Category;
    }
}


