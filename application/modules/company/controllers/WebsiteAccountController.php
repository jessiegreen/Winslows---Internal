<?php

/**
 * 
 * @author jessie
 *
 */

class Company_WebsiteAccountController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/website/account.js");
	parent::init();
    }
    
    public function editAction()
    {
	/* @var $Account \Entities\Company\Website\Account */
	$Account	= $this->getEntityFromParamFields("Company\Website\Account", array("id"));
	$safe		= !$Account->getId() || $this->getRequest()->getParam("pwd", 0) === "1" ? false : true;
	$form		= new Forms\Company\Website\Account(array("method" => "post"), $Account, $safe);
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$data	= $this->_params["company_website_account"];
		
		$Account->populate($data);
		
		if(isset($data["password"]))$Account->setPassword($data["password"]);
		
		if(!$Account->getId())
		{
		    /* @var $Person \Entities\Person\PersonAbstract */
		    $Person = $this->_em->find("Entities\Person\PersonAbstract", $this->_params["person_id"]);
		    
		    if(!$Person)
			throw new Exception("Can not add web account. No Person with that Id");

		    $Person->setAccount($Account);
		    $this->_em->persist($Person);
		}
		else $this->_em->persist($Account);

		$this->_em->flush();

		$message = "Web Account saved";
		$this->_FlashMessenger->addSuccessMessage($message);

	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack(1);
	    }
	    $this->_History->goBack(1);
	}
	
	$this->view->form	    = $form;
	$this->view->Account	    = $Account;
    }
    
    public function rolesAction()
    {
	$this->view->headScript()->appendFile("/javascript/company/website/account/roles.js");
	
	/* @var $Account \Entities\Company\Website\Account */
	$Account		    = $this->_em->find("\Entities\Company\Website\Account",$this->_params["id"]); 
	$this->view->Account	    = $Account;
	$this->view->Roles	    = $this->_em->getRepository("Entities\Company\Employee\Role")->findAll();
    }
    
    public function addroleAction()
    {
	$this->_helper->viewRenderer->setNoRender(true);
	$this->_helper->layout->disableLayout();
	
	$ACL = new Dataservice_Controller_Plugin_ACL();
	
	$ACL->preDispatch($this->_request);
	
	$Account = $this->getEntityFromParamFields("Company\Website\Account", array("id"));
	$Role	 = $this->_em->find("Entities\Company\Employee\Role", $this->_request->getParam("role_id", 0));
	
	if($Account && $Role)
	{
	    $Account->addRole($Role);
	    $this->_em->persist($Account);
	    $this->_em->flush();
	    $this->_FlashMessenger->addSuccessMessage("Role Added");
	}
	else
	{
	    $this->_FlashMessenger->addErrorMessage("Error Adding Role - Account or Role Not Available");
	}
	
	$this->_History->goBack(1);
    }
    
    public function removeroleAction()
    {
	$this->_helper->viewRenderer->setNoRender(true);
	$this->_helper->layout->disableLayout();
	
	$ACL = new Dataservice_Controller_Plugin_ACL();
	
	$ACL->preDispatch($this->_request);
	
	/* @var $Account Entities\Company\Website\Account */
	$Account = $this->getEntityFromParamFields("Company\Website\Account", array("id"));
	$Role	 = $this->_em->find("Entities\Company\Employee\Role", $this->_request->getParam("role_id", 0));
	
	if($Account && $Role)
	{
	    $Account->removeRole($Role);
	    $this->_em->persist($Account);
	    $this->_em->flush();
	    
	    $this->_FlashMessenger->addSuccessMessage("Role Removed");
	}
	else
	{
	    $this->_FlashMessenger->addErrorMessage("Error Removing Role - Account or Role Not Available");
	}
	
	$this->_History->goBack(1);
    }
}

