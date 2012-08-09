<?php

class Company_LocationAddressController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $LocationAddress \Entities\LocationAddress */
	$LocationAddress	= $this->getEntityFromParamFields("LocationAddress", array("id"));
	$form		= new Form_LocationAddress(array("method" => "post"), $LocationAddress);
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$data	= $this->_params["locationaddress"];
		
		$LocationAddress->populate($data);
		
		if(!$LocationAddress->getId()){
		    /* @var $Location \Entities\Location */
		    $Location = $this->_em->find("Entities\Location", $this->_params["location_id"]);
		    if(!$Location)
			throw new Exception("Can not add address. No Location with that Id");

		    $Location->setLocationAddress($LocationAddress);
		    $this->_em->persist($Location);
		}
		else $this->_em->persist($LocationAddress);

		$this->_em->flush();

		$message = "Location Address saved";
		$this->_FlashMessenger->addSuccessMessage($message);

	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack(1);
	    }
	    $this->_History->goBack(1);
	}
	
	$this->view->form		= $form;
	$this->view->LocationAddress	= $LocationAddress;
    }
}

