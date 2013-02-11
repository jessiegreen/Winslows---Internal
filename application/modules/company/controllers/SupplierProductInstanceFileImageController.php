<?php

/**
 * 
 * @author jessie
 *
 */

class Company_SupplierProductInstanceFileImageController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $Image \Entities\Company\Supplier\Product\Instance\File\Image */
	$Image	    = $this->getEntityFromParamFields('Company\Supplier\Product\Instance\File\Image', array("id"));
	$instance_id = $this->getRequest()->getParam("instance_id"); 
	
	if(!$Image->getId())
	{	    
	    if($instance_id)
	    {
		$Instance = $this->_em->getRepository("Entities\Company\Supplier\Product\Instance\InstanceAbstract")->find($instance_id);
		
		if(!$Instance)
		{
		    $this->_FlashMessenger->addErrorMessage("Could not get Instance.");
		    $this->_History->goBack();
		}
		
		$Image->setInstance($Instance);
	    } 
	    else
	    {
		$this->_FlashMessenger->addErrorMessage("Could not get Instance Id.");
		$this->_History->goBack();
	    }
	}
	
	$form = new Forms\Company\Supplier\Product\Instance\File\Image($Image, array("method" => "post"));
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	    = $this->_getParam("company_supplier_product_instance_file_image");
		$info_array = $_FILES["file"];
		
		$Image->setFileParamsFromArray($info_array);
		$Image->setWidth("");
		$Image->setHeight("");
		$Image->populate($data);
		
		/* @var $Instance Entities\Company\Supplier\Product\Instance\InstanceAbstract */
		$Instance = $this->_em->getRepository("Entities\Company\Supplier\Product\Instance\InstanceAbstract")->find($data["instance_id"]);
		
		if(!$Instance)
		{
		    $this->_FlashMessenger->addErrorMessage("Could not get Instance.");
		    $this->_History->goBack();
		}
		
		$Image->setInstance($Instance);
		
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

