<?php

/**
 * 
 * @author jessie
 *
 */

class Company_SupplierProductCategoryFileImageController extends Dataservice_Controller_Action
{    
    public function init()
    {
	//$this->view->headScript()->appendFile("/javascript/company/supplier/product/category/file/image.js");
	
	parent::init();
    }
    
    public function editAction()
    {
	/* @var $Image \Entities\Company\Supplier\Product\Category\File\Image */
	$Image		= $this->getEntityFromParamFields('Company\Supplier\Product\Category\File\Image', array("id"));
	$category_id	= $this->getRequest()->getParam("category_id"); 
	
	if(!$Image->getId())
	{	    
	    if($category_id)
	    {
		$Category = $this->_em->getRepository("Entities\Company\Supplier\Product\Category")->find($category_id);
		
		if(!$Category)
		{
		    $this->_FlashMessenger->addErrorMessage("Could not get Category.");
		    $this->_History->goBack();
		}
		
		$Image->setCategory($Category);
	    } 
	    else
	    {
		$this->_FlashMessenger->addErrorMessage("Could not get Category Id.");
		$this->_History->goBack();
	    }
	}
	
	$form = new Forms\Company\Supplier\Product\Category\File\Image($Image, array("method" => "post"));
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	    = $this->_params["company_supplier_product_category_file_image"];
		$info_array = $_FILES["file"];
		
		$Image->setFileParamsFromArray($info_array);
		$Image->setWidth("");
		$Image->setHeight("");
		$Image->populate($data);
		
		/* @var $Category Entities\Company\Supplier\Product\Category */
		$Category = $this->_em->getRepository("Entities\Company\Supplier\Product\Category")->find($data["category_id"]);
		
		if(!$Category)
		{
		    $this->_FlashMessenger->addErrorMessage("Could not get Category.");
		    $this->_History->goBack();
		}
		
		$Image->setCategory($Category);
		
		$this->_em->persist($Image);
		$this->_em->flush();
		
		$Image->uploadFile($info_array["tmp_name"]);
		
		$this->_em->persist($Image);
		$this->_em->flush();

		$message = "Image saved";
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
	$this->view->Image	= $Image;
    }
}

