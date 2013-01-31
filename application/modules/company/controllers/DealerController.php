<?php
class Company_DealerController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Dealer";
	
	parent::init();
    }
    
    public function viewAction()
    {
	$this->_entityRequired();
    }
    
    public function editAction()
    {
	$company_id = $this->getRequest()->getParam("company_id");
	
	if(!$this->_Entity->getId() && $company_id)
	{
	    $Company = $this->_em->getRepository("Entities\Company")->find($company_id);

	    if($Company)
	    {
		$this->_Entity->setCompany($Company);
	    }
	}
	
	$form = $this->_Entity->getEditForm()->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$dealer_data = $this->_getParam("company_dealer", array());

		$this->_Entity->populate($dealer_data);
		
		if($dealer_data["company_id"])
		{
		    $Company = $this->_em->find("Entities\Company", $dealer_data["company_id"]);
		    
		    if($Company)
			$this->_Entity->setCompany($Company);
		}
		
		$this->_em->persist($this->_Entity);
		$this->_em->flush();

		$message = "Dealer '".htmlspecialchars($this->_Entity->getName())."' saved";
		
		$this->_FlashMessenger->addSuccessMessage($message);
	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    }
	    
	    $this->_History->goBack();
	}
	
	$this->view->form	= $form;
	$this->view->Dealer	= $this->_Entity;
    }
    
    public function deleteAction()
    {
	$this->_deleteEntity();
    }
}

