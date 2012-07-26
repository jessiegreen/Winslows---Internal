<?php

/**
 * 
 * @author jessie
 *
 */

class SupplieraddressController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $SupplierAddress \Entities\SupplierAddress */
	$SupplierAddress	= $this->getEntityFromParamFields("SupplierAddress", array("id"));
	$form		= new Form_SupplierAddress(array("method" => "post"), $SupplierAddress);
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$data	= $this->_params["supplieraddress"];
		
		$SupplierAddress->populate($data);
		
		if(!$SupplierAddress->getId()){
		    /* @var $Person \Entities\Person */
		    $Supplier = $this->_em->find("Entities\Supplier", $this->_params["supplier_id"]);
		    if(!$Supplier)
			throw new Exception("Can not add address. No Supplier with that Id");

		    $Supplier->addSupplierAddress($SupplierAddress);
		    $this->_em->persist($Supplier);
		}
		else $this->_em->persist($SupplierAddress);

		$this->_em->flush();

		$message = "Supplier Address saved";
		$this->_FlashMessenger->addSuccessMessage($message);

	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack(1);
	    }
	    $this->_History->goBack(1);
	}
	
	$this->view->form		= $form;
	$this->view->SupplierAddress	= $SupplierAddress;
    }
}

