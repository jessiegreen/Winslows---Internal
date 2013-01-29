<?php
class Company_WebsiteRoleController extends Dataservice_Controller_Action
{
    public function viewAction()
    {
	$Role = $this->getEntityFromParamFields("Website\Role", array("id"));
	
	if(!$Role->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Role.");
	}
	
	$this->view->Role = $Role;
    }
    
    public function editAction()
    {
	$Role	    = $this->getEntityFromParamFields("Website\Role", array("id"));
	$website_id = $this->getRequest()->getParam("website_id");
	
	if(!$Role->getId())
	{
	    if($website_id)
	    {
		$Website = $this->_em->getRepository("Entities\Company\Website")->find($website_id);
		
		if($Website)$Role->setWebsite($Website);
	    }
	}
	
	$form = new \Forms\Company\Website\Role($Role, array("method" => "post"));
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data = $this->getRequest()->getParam("website_role");

		if($data["website_id"])
		{
		    $Website = $this->_em->getRepository("Entities\Company\Website")->find($data["website_id"]);

		    if($Website)$Role->setWebsite($Website);
		}

		$Role->populate($data);

		if($data["admin_role"] == 1)
		    $Website->setAdminRole($Role);
		
		if($data["guest_role"] == 1)
		    $Website->setGuestRole($Role);
		
		$this->_em->persist($Role);
		$this->_em->persist($Website);
		$this->_em->flush();
		
		$this->_FlashMessenger->addSuccessMessage("Role edited");
		$this->_History->goBack();
	    }
	    catch (Exception $exc) 
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->Role = $Role;
	$this->view->form = $form;
    }
}