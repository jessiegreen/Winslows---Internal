<?php
class Company_WebsiteController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/website.js");
	
	$this->_EntityClass = "Entities\Company\Website";
	
	parent::init();
    }
    
    public function buildResourcesAction()
    {
	/* @var $em \Doctrine\ORM\EntityManager */
	$objResources	= new Dataservice_ACL_Resources;
	
	$this->_requireEntity();
	
	$Default_Role = $this->_Entity->isGuestAllowed() ? $this->_Entity->getGuestRole() : $this->_Entity->getAdminRole();
	    
	$objResources->buildAllArrays($this->_Entity->getNameIndex());
	$objResources->writeToDB($this->_em, $this->_Entity, $Default_Role);
	
	$this->_FlashMessenger->addSuccessMessage("Resources built");
	$this->_History->goBack();
    }
    
    public function cleanResourcesAction()
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
    
    public function manageCatalogsAction()
    {
	$this->_requireEntity();
	
	$form = new Forms\Company\Website\ManageCatalogs($this->_Entity, array("method" => "post"));

	$form->addCancelButton($this->_History->getPreviousUrl());

	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$post_data		= $this->_request->getPost();
		$data			= $post_data["company_website_manage_catalogs"];
		$catalogs		= $data["catalogs"];
		$current_catalogs	= array();

		foreach ($this->_Entity->getCatalogs() as $Catalog)
		{
		    if(!in_array($Catalog->getId(), $catalogs))
		    {
			$Catalog->removeWebsite($this->_Entity);
			$this->_em->persist($Catalog);
		    }

		    $current_catalogs[] = $Catalog->getId();
		}

		foreach ($catalogs as $value) 
		{
		    if(!in_array($value, $current_catalogs))
		    {
			$Catalog = $this->_em->find("\Entities\Company\Catalog", $value);

			$Catalog->addWebsite($this->_Entity);
			    
			$this->_em->persist($Catalog);
		    }
		}

		$this->_em->flush();

		$this->_FlashMessenger->addSuccessMessage("Website catalogs saved.");
		$this->_History->goBack();
	    }
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->form = $form;
    }
}

