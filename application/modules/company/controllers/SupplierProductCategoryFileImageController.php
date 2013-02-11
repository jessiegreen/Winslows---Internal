<?php
class Company_SupplierProductCategoryFileImageController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Supplier\Product\Category\File\Image";
	
	parent::init();
    }
    
    public function editAction()
    {
	$this->_Entity->populate($this->_getAllParams());
	
	$form = new Forms\Company\Supplier\Product\Category\File\Image($this->_Entity, array("method" => "post"));
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	    = $this->_getParam("company_supplier_product_category_file_image");
		$info_array = $_FILES["file"];
		
		$this->_Entity->setFileParamsFromArray($info_array);
		$this->_Entity->setWidth("");
		$this->_Entity->setHeight("");
		$this->_Entity->populate($data);
		
		$this->_em->persist($this->_Entity);
		$this->_em->flush();
		
		$this->_Entity->uploadFile($info_array["tmp_name"]);
		
		$this->_em->persist($this->_Entity);
		$this->_em->flush();

		$message = "Image saved";
		$this->_FlashMessenger->addSuccessMessage($message);

	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    }
	    
	    $this->_History->goBack();
	}
	
	$this->view->form = $form;
    }
}

