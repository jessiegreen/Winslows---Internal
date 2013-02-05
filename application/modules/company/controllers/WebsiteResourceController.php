<?php
class Company_WebsiteResourceController extends Dataservice_Controller_Crud_Action
{
    public function init() 
    {
	$this->_EntityClass = "Entities\Company\Website\Resource";
	
	parent::init();
    }

    public function buildAction()
    {
	/* @var $em \Doctrine\ORM\EntityManager */
	$objResources	= new Dataservice_ACL_Resources;
	$website_id	= $this->getRequest()->getParam("website_id");
	
	/* @var $Website \Entities\Company\Website\WebsiteAbstract */ 
	if($website_id)$Website = $this->_em->getRepository ("Entities\Company\Website")->find ($website_id);
	else $this->_FlashMessenger->addErrorMessage("Could not build resources. Website id not sent");
	
	if(!$Website->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not build resources. Could not get company");
	    $this->_History->goBack();
	}	
	
	$Default_Role  = $Website->isGuestAllowed() ? $Website->getGuestRole() : $Website->getAdminRole();
	    
	$objResources->buildAllArrays($Website->getNameIndex());
	$objResources->writeToDB($this->_em, $Website, $Default_Role);
	
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
    
    public function manageRolesAction()
    {	
	/* @var $Resource Entities\Company\Website\Resource */
	$Resource = $this->_getResource();
	
	$this->_CheckRequiredResourceExists($Resource);
	
	$form = new Forms\Company\Website\Resource\ManageRoles($Resource);
	
	if($this->isPostAndValid($form))
	{
	    try
	    {
		$data = $this->getRequest()->getParam("website_resource_manage_roles");
	    
		$Resource->getRoles()->clear();
		
		if(isset($data["role_id"]) && is_array($data["role_id"]) && count($data["role_id"]))
		{
		    $Website = $Resource->getWebsite();

		    foreach($data["role_id"] as $role_id)
		    {
			$Role = $Website->getRoleById($role_id);
			
			if($Role)
			{
			    $Resource->addRole($Role);
			}
		    }
		}

		$this->_em->persist($Resource);
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