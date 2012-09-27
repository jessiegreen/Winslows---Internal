<?php
class Company_WebsiteResourceController extends Dataservice_Controller_Action
{
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/website/resource/resource.js");
	parent::init();
    }

    public function buildAction()
    {
	/* @var $em \Doctrine\ORM\EntityManager */
	$objResources	= new Dataservice_ACL_Resources;
	$website_id	= $this->_request->getParam("website_id");
	
	if($website_id)$Website = $this->_em->getRepository ("Entities\Company\Website")->find ($website_id);
	else $this->_FlashMessenger->addErrorMessage("Could not build resources. Company id not sent");
	
	if(!$Website->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not build resources. Could not get company");
	    $this->_History->goBack();
	}	
	
	$objResources->buildAllArrays($Website->getNameIndex());
	$objResources->writeToDB($this->_em, $Website);
	
	$this->_FlashMessenger->addSuccessMessage("Resources built");
	$this->_History->goBack();
    }
    
    public function cleanAction()
    {
	try 
	{
	    /* @var $em \Doctrine\ORM\EntityManager */
	    $objResources	= new Dataservice_ACL_Resources;
	    $this->view->result = $objResources->cleanDB($this->_em);
	} 
	catch (Exception $exc) 
	{
	    $this->_FlashMessenger->addErrorMessage($exc->getMessage());
	}
    }
    
    public function viewAllAction()
    {	
	$this->view->Resources	= $this->_em->getRepository("Entities\Website\Resource")->findAll();
    }
    
    public function manageRolesAction()
    {	
	$this->view->headScript()->appendFile("/javascript/website/resource/manage-roles.js");
	
	if(isset($this->_params["id"]))
	{
	    /* @var $Resource \Entities\Website\Resource */
	    $Resource		    = $this->_em->find("\Entities\Website\Resource",$this->_params["id"]); 
	    $this->view->Resource   = $Resource;
	    $this->view->Roles	    = $this->_em->getRepository("Entities\Role\RoleAbstract")->findAll();
	}
    }
    
    public function removeRoleAction()
    {
	$this->_helper->viewRenderer->setNoRender(true);
	$this->_helper->layout->disableLayout();
	
//	$ACL = new Dataservice_Controller_Plugin_ACL();
//	
//	$ACL->preDispatch($this->_request);
	
	$resource_id	= isset($this->_params["resource_id"]) ? $this->_params["resource_id"] : null;
	$role_id	= isset($this->_params["role_id"]) ? $this->_params["role_id"] : null;
	
	if($resource_id && $role_id)
	{
	    $Resource	= $this->_em->find("Entities\Website\Resource", $resource_id);
	    /* @var $Resource \Entities\Website\Resource */
	    $Role	= $this->_em->find("Entities\Role\RoleAbstract", $role_id);
	    
	    if($Role->getName() === "Web Admin")
	    {
		$this->_FlashMessenger->addErrorMessage("Can not remove admin");
		$this->_History->goBack();
	    }
	    elseif($Resource && $Role)
	    {
		try 
		{
		    $Resource->removeRole($Role);
		
		    $this->_em->persist($Resource);
		    $this->_em->flush();
		    $this->_FlashMessenger->addSuccessMessage("Role Removed");
		} 
		catch (Exception $exc)
		{
		    $this->_FlashMessenger->addErrorMessage($exc->getMessage());
		}		
	    }
	    else
	    {
		$this->_FlashMessenger->addErrorMessage("Error Removing Role - Resource or Role Not Found");
	    }
	    
	    $this->_redirect('/website/resource/manage-roles/id/'.$resource_id);
	}
	else
	{
	    $this->_FlashMessenger->addErrorMessage("Error Removing Role - Resource or Role Not Sent");
	    $this->_redirect('/website/resource/view-all');
	}
    }
    
    public function addRoleAction()
    {
	$this->_helper->viewRenderer->setNoRender(true);
	$this->_helper->layout->disableLayout();
	
	$ACL = new Dataservice_Controller_Plugin_ACL();
	
	$ACL->preDispatch($this->_request);
	
	$resource_id	= isset($this->_params["resource_id"]) ? $this->_params["resource_id"] : null;
	$role_id	= isset($this->_params["role_id"]) ? $this->_params["role_id"] : null;
	
	if($resource_id && $role_id)
	{
	    /* @var $Resource \Entities\Website\Resource */
	    $Resource	= $this->_em->find("Entities\Website\Resource", $resource_id);
	    $Role	= $this->_em->find("Entities\Role\RoleAbstract", $role_id);
	    
	    if($Resource && $Role)
	    {
		try 
		{
		    $Resource->addRole($Role);
		    $this->_em->persist($Resource);
		    $this->_em->flush();
		    $this->_FlashMessenger->addSuccessMessage("Role Added");
		} 
		catch (Exception $exc)
		{
		    $this->_FlashMessenger->addErrorMessage($exc->getMessage());
		}
		
		$this->_redirect('/website/resource/manage-roles/id/'.$resource_id);
	    }
	    else
	    {
		$this->_FlashMessenger->addErrorMessage("Error Adding Role - Resource or Role Not Available");
	    }
	}
	else
	{
	    $this->_FlashMessenger->addErrorMessage("Error Adding Role - Resource or Role Not Sent");
	}
	
	$this->_redirect('/website/resource/view-all');
    }
}