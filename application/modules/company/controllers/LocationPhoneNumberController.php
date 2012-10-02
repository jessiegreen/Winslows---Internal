<?php

/**
 * 
 * @author jessie
 *
 */

class Company_LocationPhoneNumberController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $LocationPhoneNumber \Entities\Location\PhoneNumber */
	$LocationPhoneNumber	= $this->getEntityFromParamFields("Location\PhoneNumber", array("id"));
	$form			= new Forms\Company\Location\PhoneNumber(array("method" => "post"), $LocationPhoneNumber);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$data	= $this->_params["company_location_phonenumber"];
		
		$LocationPhoneNumber->populate($data);
		$LocationPhoneNumber->setAreaCode($data["phone_number"]["area"]);
		$LocationPhoneNumber->setNum1($data["phone_number"]["prefix"]);
		$LocationPhoneNumber->setNum2($data["phone_number"]["line"]);
		
		if(!$LocationPhoneNumber->getId()){
		    /* @var $Location \Entities\Company\Location */
		    $Location = $this->_em->find("Entities\Company\Location", $this->_params["location_id"]);
		    if(!$Location)
			throw new Exception("Can not add phone number. No Location with that Id");

		    $Location->setPhoneNumber($LocationPhoneNumber);
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

