<?php

class Company_DealerLocationAddressController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $LocationAddress \Entities\Location\Address */
	$LocationAddress    = $this->getEntityFromParamFields("Location\Address", array("id"));
	$location_id	    = $this->_request->getParam("location_id");
	
	if(!$LocationAddress->getId())
	{
	    if($location_id)
	    {
		$Location = $this->_em->getRepository("Entities\Company\Dealer\Location")->find($location_id);
		
		if($Location)$LocationAddress->setLocation($Location);
	    }
	}
	
	$form = new Forms\Company\Dealer\Location\Address(array("method" => "post"), $LocationAddress);
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data = $this->_params["company_dealer_location_address"];
		
		if($data["location_id"])
		{
		    $Location = $this->_em->getRepository("Entities\Company\Dealer\Location")->find($data["location_id"]);
		    
		    if($Location)$LocationAddress->setLocation ($Location);
		}
		
		$LocationAddress->populate($data);

		$this->_em->persist($LocationAddress);
		$this->_em->flush();

		$message = "Dealer Location Address saved";
		
		$this->_FlashMessenger->addSuccessMessage($message);

	    } 
	    catch (Exception $exc) 
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	    
	    $this->_History->goBack();
	}
	
	$this->view->form		= $form;
	$this->view->LocationAddress	= $LocationAddress;
    }
}