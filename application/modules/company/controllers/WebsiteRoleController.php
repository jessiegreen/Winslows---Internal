<?php
class Company_WebsiteRoleController extends Dataservice_Controller_Crud_Action
{    
    public function init() 
    {
	$this->_EntityClass = "Entities\Company\Website\Role";
	
	parent::init();
    }
    
    public function manageResourcesAction()
    {
	$this->_requireEntity();
	
	$form = new \Forms\Company\Website\Role\ManageResources($this->_Entity, array("method" => "post"));
		    
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$post = $this->_request->getPost();

		$data = $post["company_website_role_manage_resources"];

		foreach($this->_Entity->getResources() as $Resource)
		{
		    if(!in_array($Resource->getId(), $data["resources"]))
		    {
			$Resource->getRoles()->removeElement($this->_Entity);
			
			$this->_em->persist($Resource);
		    }
		}
		
		foreach($data["resources"] as $resource_id)
		{
		    $Resource = $this->_em->find("Entities\Company\Website\Resource", $resource_id);

		    if($Resource && !$Resource->getRoles()->contains($this->_Entity))
		    {
			$Resource->addRole($this->_Entity);
		    
			$this->_em->persist($Resource);
		    }
		}
		
		$this->_em->flush();
		
		$this->_FlashMessenger->addSuccessMessage("Resources Saved");
	    } 
	    catch (Exception $exc) 
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    }

	    $this->_History->goBack();
	}
	
	$this->view->form = $form;
    }
}