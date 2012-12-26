<?php

/**
 * 
 * @author jessie
 *
 */

class Company_SupplierProductFileImageController extends Dataservice_Controller_Action
{    
    public function init()
    {
	//$this->view->headScript()->appendFile("/javascript/company/supplier/product/file/image.js");
	
	parent::init();
    }
    
    public function editAction()
    {
	/* @var $Image \Entities\Company\Supplier\Product\File\Image */
	$Image	    = $this->getEntityFromParamFields('Company\Supplier\Product\File\Image', array("id"));
	$product_id = $this->getRequest()->getParam("product_id"); 
	
	if(!$Image->getId())
	{	    
	    if($product_id)
	    {
		$Product = $this->_em->getRepository("Entities\Company\Supplier\Product\ProductAbstract")->find($product_id);
		
		if(!$Product)
		{
		    $this->_FlashMessenger->addErrorMessage("Could not get Product.");
		    $this->_History->goBack();
		}
		
		$Image->setProduct($Product);
	    } 
	    else
	    {
		$this->_FlashMessenger->addErrorMessage("Could not get Product Id.");
		$this->_History->goBack();
	    }
	}
	
	$form = new Forms\Company\Supplier\Product\File\Image($Image, array("method" => "post"));
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	    = $this->_params["company_supplier_product_file_image"];
		$info_array = $_FILES["file"];
		
		$Image->setFileParamsFromArray($info_array);
		$Image->setWidth("");
		$Image->setHeight("");
		$Image->populate($data);
		
		/* @var $Product Entities\Company\Supplier\Product\ProductAbstract */
		$Product = $this->_em->getRepository("Entities\Company\Supplier\Product\ProductAbstract")->find($data["product_id"]);
		
		if(!$Product)
		{
		    $this->_FlashMessenger->addErrorMessage("Could not get Product.");
		    $this->_History->goBack();
		}
		
		$Image->setProduct($Product);
		
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
    
    /**
     * @return \Entities\Company\Supplier\Product\ProductAbstract
     */
    private function _getProduct()
    {
	$id = $this->getRequest()->getParam("product_id", 0);
	
	return $this->_em->find("Entities\Company\Supplier\Product\ProductAbstract", $id);
    }
}

