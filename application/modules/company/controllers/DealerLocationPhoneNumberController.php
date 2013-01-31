<?php

/**
 * 
 * @author jessie
 *
 */

class Company_DealerLocationPhoneNumberController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $LocationPhoneNumber \Entities\Company\Location\PhoneNumber */
	$LocationPhoneNumber	= $this->getEntityFromParamFields("Location\PhoneNumber", array("id"));
	$location_id		= $this->getRequest()->getParam("location_id");
	
	if(!$LocationPhoneNumber->getId())
	{
	    if($location_id)
	    {
		$Location = $this->_em->getRepository("Entities\Company\Dealer\Location")->find($location_id);
		
		if($Location)$LocationPhoneNumber->setLocation($Location);
	    }
	}
	
	$form = new Forms\Company\Dealer\Location\PhoneNumber(array("method" => "post"), $LocationPhoneNumber);
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["company_dealer_location_phonenumber"];
		
		if($data["location_id"])
		{
		    $Location = $this->_em->getRepository("Entities\Company\Dealer\Location")->find($data["location_id"]);
		    
		    if($Location)$LocationPhoneNumber->setLocation ($Location);
		}
		
		$LocationPhoneNumber->populate($data);
		$LocationPhoneNumber->setAreaCode($data["phone_number"]["area"]);
		$LocationPhoneNumber->setNum1($data["phone_number"]["prefix"]);
		$LocationPhoneNumber->setNum2($data["phone_number"]["line"]);
		
		$this->_em->persist($LocationPhoneNumber);
		$this->_em->flush();

		$message = "Location Phone Number saved";
		
		$this->_FlashMessenger->addSuccessMessage($message);
	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	    
	    $this->_History->goBack();
	}
	
	$this->view->form		    = $form;
	$this->view->LocationPhoneNumber    = $LocationPhoneNumber;
    }
}

