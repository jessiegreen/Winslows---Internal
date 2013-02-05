<?php
class Company_WebsiteResourceController extends Dataservice_Controller_Crud_Action
{
    public function init() 
    {
	$this->_EntityClass = "Entities\Company\Website\Resource";
	
	parent::init();
    }
    
    public function manageRolesAction()
    {	
	$this->_requireEntity();
	
	$form = new Forms\Company\Website\Resource\ManageRoles($this->_Entity);
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try
	    {
		$data = $this->getRequest()->getParam("website_resource_manage_roles");
	    
		$this->_Entity->getRoles()->clear();
		
		if(isset($data["role_id"]) && is_array($data["role_id"]) && count($data["role_id"]))
		{
		    $Website = $this->_Entity->getWebsite();

		    foreach($data["role_id"] as $role_id)
		    {
			$Role = $Website->getRoleById($role_id);
			
			if($Role)
			{
			    $this->_Entity->addRole($Role);
			}
		    }
		}

		$this->_em->persist($this->_Entity);
		$this->_em->flush();
		
		$this->_FlashMessenger->addSuccessMessage("Roles saved.");
		$this->_History->goBack();
	    }
	    catch (\Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->form = $form;
    }
}