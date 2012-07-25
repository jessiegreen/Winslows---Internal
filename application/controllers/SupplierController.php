<?php

/**
 * 
 * @author jessie
 *
 */

class SupplierController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/supplier/supplier.js");
	parent::init();
    }
    
    public function viewAction()
    {
	$Supplier = $this->getEntityFromParamFields("Supplier", array("id"));
	
	if(!$Supplier->getId()){
	    $this->_FlashMessenger->addErrorMessage("Could not get Supplier");
	    $this->_redirect('/supplier/viewall');
	}
	
	$this->view->Supplier	= $Supplier;
    }
    
    public function viewallAction()
    {
	$SupplierRepos		= $this->_em->getRepository("Entities\Supplier");
	$this->view->Suppliers	= $SupplierRepos->findAll();
    }
    
    public function editAction()
    {
	$Supplier = $this->getEntityFromParamFields("Supplier", array("id"));
	
	$form = new Form_Supplier(array("method" => "post"), $Supplier);
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$supplier_data	= $this->_params["supplier"];

		$Supplier->populate($supplier_data);
		$this->_em->persist($Supplier);
		$this->_em->flush();

		$message = "Supplier '".htmlspecialchars($Supplier->getFullName())."' saved";
		$this->_FlashMessenger->addSuccessMessage($message);
		$this->_History->goBack(1);
	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack(1);
	    }
	}
	
	$this->view->form	= $form;
	$this->view->Supplier	= $Supplier;
    }
}

