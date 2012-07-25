<?php

/**
 * 
 * @author jessie
 *
 */

class LocationphonenumberController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $LocationPhoneNumber \Entities\LocationPhoneNumber */
	$LocationPhoneNumber  = $this->getEntityFromParamFields("LocationPhoneNumber", array("id"));
	$form		    = new Form_LocationPhoneNumber(array("method" => "post"), $LocationPhoneNumber);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$data	= $this->_params["locationphonenumber"];
		
		$LocationPhoneNumber->populate($data);
		$LocationPhoneNumber->setAreaCode($data["phone_number"]["area"]);
		$LocationPhoneNumber->setNum1($data["phone_number"]["prefix"]);
		$LocationPhoneNumber->setNum2($data["phone_number"]["line"]);
		
		if(!$LocationPhoneNumber->getId()){
		    /* @var $Location \Entities\Location */
		    $Location = $this->_em->find("Entities\Location", $this->_params["location_id"]);
		    if(!$Location)
			throw new Exception("Can not add address. No Location with that Id");

		    $Location->setLocationPhoneNumber($LocationPhoneNumber);
		    $this->_em->persist($Location);
		}
		else $this->_em->persist($LocationPhoneNumber);

		$this->_em->flush();

		$message = "Location Phone Number saved";
		$this->_FlashMessenger->addSuccessMessage($message);

	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack(1);
	    }
	    $this->_History->goBack(1);
	}
	
	$this->view->form		= $form;
	$this->view->LocationPhoneNumber  = $LocationPhoneNumber;
    }
}

