<?php
class Company_SupplierAddressController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $SupplierAddress \Entities\SupplierAddress */
	$Address    = $this->getEntityFromParamFields("Company\Supplier\Address", array("id"));
	$form	    = new Forms\Company\Supplier\Address(array("method" => "post"), $Address);
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["company_supplier_address"];
		
		$Address->populate($data);
		
		if(!$Address->getId())
		{
		    /* @var $Supplier \Entities\Company\Supplier */
		    $Supplier = $this->_em->find("Entities\Company\Supplier", $this->_params["supplier_id"]);
		    
		    if(!$Supplier)
			throw new Exception("Can not add address. No Supplier with that Id");

		    $Supplier->addAddress($Address);
		    $this->_em->persist($Supplier);
		}
		else $this->_em->persist($Address);

		$this->_em->flush();

		$message = "Supplier Address saved";
		
		$this->_FlashMessenger->addSuccessMessage($message);
	    } 
	    catch (Exception $exc) 
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack(1);
	    }
	    $this->_History->goBack(1);
	}
	
	$this->view->form		= $form;
	$this->view->SupplierAddress	= $Address;
    }
}

