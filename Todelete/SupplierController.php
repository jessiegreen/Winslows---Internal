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
	$Supplier = $this->getEntityFromParamFields("Company\Supplier", array("id"));
	
	if(!$Supplier->getId()){
	    $this->_FlashMessenger->addErrorMessage("Could not get Supplier");
	    $this->_redirect('/company-supplier/viewall');
	}
	
	$this->view->Supplier	= $Supplier;
    }
    
    public function viewallAction()
    {
	$SupplierRepos		= $this->_em->getRepository("Entities\Company\Supplier");
	$this->view->Suppliers	= $SupplierRepos->findAll();
    }
    
    public function editAction()
    {
	$Supplier = $this->getEntityFromParamFields("Company\Supplier", array("id"));
	
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

		$message = "Supplier '".htmlspecialchars($Supplier->getName())."' saved";
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
    
    public function addcompanyAction()
    {
	$supplier_id = $this->_getParam("id");
	
	if($supplier_id){
	    $Supplier = $this->_em->find("Entities\Company\Supplier", $supplier_id);
	    if(!$Supplier){
		$this->_FlashMessenger->addErrorMessage("No Supplier With that Id");
		$this->_History->goBack();
	    }
	}
	else{
	    $this->_FlashMessenger->addErrorMessage("No Supplier Id Sent");
	    $this->_History->goBack();
	}
	
	$form = new Form_Supplier_AddCompany(array("method" => "post"));
	if($this->isPostAndValid($form)){
	    try {
		$Company = $this->_em->find("Entities\Company", $this->_params["supplier_addcompany"]["company_id"]);
		if($Company){
		    $Supplier->addCompany($Company);
		    $this->_em->persist($Supplier);
		    $this->_em->flush();
		    $message = "Company '".htmlspecialchars($Company->getName())."' added.";
		    $this->_FlashMessenger->addSuccessMessage($message);
		    $this->_History->goBack(1);
		}
		else throw new Exception("Could Not Add Company. No Supplier With that Id Exists.");
	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack(1);
	    }
	}
	
	$this->view->form = $form;
    }
}

