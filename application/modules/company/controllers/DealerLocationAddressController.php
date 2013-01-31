<?php
class Company_DealerLocationAddressController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Dealer\Location\Address";
	
	parent::init();
    }
    
    public function editAction()
    {
	$location_id = $this->getRequest()->getParam("location_id");
	
	if(!$this->_Entity->getId())
	{
	    if($location_id)
	    {
		$Location = $this->_em->find("Entities\Company\Dealer\Location", $location_id);
		
		if($Location)$this->_Entity->setLocation($Location);
	    }
	}
	
	$form = $this->_Entity->getEditForm()->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data = $this->_getParam("company_dealer_location_address", array());
		
		$Location = $this->_em->getRepository("Entities\Company\Dealer\Location")->find($data["location_id"]);

		if($Location)$this->_Entity->setLocation($Location);
		
		$this->_Entity->populate($data);

		$this->_em->persist($this->_Entity);
		$this->_em->flush();

		$message = "Dealer Location Address saved";
		
		$this->_FlashMessenger->addSuccessMessage($message);

	    } 
	    catch (Exception $exc) 
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    }
	    
	    $this->_History->goBack();
	}
	
	$this->view->form	= $form;
	$this->view->Address	= $this->_Entity;
    }
}