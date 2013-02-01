<?php
class Company_DealerLocationController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Dealer\Location";
	
	parent::init();
    }
    
    public function viewAction()
    {
	$this->_entityRequired();
    }
    
    public function editAction()
    {
	$Location   = $this->getEntityFromParamFields("Company\Dealer\Location", array("id"));
	$dealer_id  = $this->getRequest()->getParam("dealer_id", null);
	
	if($dealer_id)
	{
	    $Dealer = $this->_em->find("Entities\Company\Dealer", $dealer_id);
	    
	    if($Dealer)$Location->setDealer($Dealer);
	}
	
	$form = new Forms\Company\Dealer\Location(array("method" => "post"), $Location);
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$location_data	= $this->_params["company_dealer_location"];
		$Dealer		= $this->_em->find("Entities\Company\Dealer", $location_data["dealer_id"]);
		
		if($Dealer)$Location->setDealer($Dealer);
		
		$Location->populate($location_data);
		$this->_em->persist($Location);
		$this->_em->flush();

		$message = "Location '".htmlspecialchars($Location->getName())."' saved";
		
		$this->_FlashMessenger->addSuccessMessage($message);
		$this->_History->goBack();
	    } 
	    catch (Exception $exc) 
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->form	= $form;
	$this->view->Location	= $Location;
    }
}