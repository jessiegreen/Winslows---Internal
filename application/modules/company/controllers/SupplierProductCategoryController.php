<?php

/**
 * 
 * @author jessie
 *
 */

class Company_SupplierProductCategoryController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/supplier/product/category.js");
	parent::init();
    }
    
    public function editAction()
    {
	/* @var $Category \Entities\Company\Supplier\Product\Category */
	$Category = $this->getEntityFromParamFields('Company\Supplier\Product\Category', array("id"));
	
	$form = new \Forms\Company\Supplier\Product\Category(array("method" => "post"), $Category);
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["company_supplier_product_category"];
		
		if($data["parent_id"])
		{
		    $Parent = $this->_em->getRepository("Entities\Company\Supplier\Product\Category")->find($data["parent_id"]);
		    
		    if($Parent)$Category->setParent ($Parent);
		}
		
		$Category->populate($data);
		$this->_em->persist($Category);
		$this->_em->flush();

		$message = "Category saved";
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
	$this->view->Category	= $Category;
    }
}

