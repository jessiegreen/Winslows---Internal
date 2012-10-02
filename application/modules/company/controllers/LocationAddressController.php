<?php

class Company_LocationAddressController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $LocationAddress \Entities\Company\Location\Address */
	$LocationAddress    = $this->getEntityFromParamFields("Location\Address", array("id"));
	$form		    = new Forms\Company\Location\Address(array("method" => "post"), $LocationAddress);
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["company_location_address"];
		
		$LocationAddress->populate($data);
		
		if(!$LocationAddress->getId())
		{
		    /* @var $Location \Entities\Company\Location */
		    $Location = $this->_em->find("Entities\Company\Location", $this->_params["location_id"]);
		    
		    if(!$Location)
			throw new Exception("Can not add address. No Location with that Id");

		    $Location->setAddress($LocationAddress);
		    $this->_em->persist($Location);
		}
		else $this->_em->persist($LocationAddress);

		$this->_em->flush();

		$message = "Location Address saved";
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
	$this->view->LocationAddress	= $LocationAddress;
    }
}

