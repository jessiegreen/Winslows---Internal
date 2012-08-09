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
	$this->view->headScript()->appendFile("/javascript/webaccount/webaccount.js");
	parent::init();
    }
    
    public function editAction()
    {
	/* @var $WebAccount \Entities\Company\Website\Account */
	$WebAccount	= $this->getEntityFromParamFields("WebAccount", array("id"));
	$safe		= !$WebAccount->getId() || $this->getRequest()->getParam("pwd", 0) === "1" ? false : true;
	$form		= new Form_WebAccount(array("method" => "post"), $WebAccount, $safe);
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$data	= $this->_params["webaccount"];
		
		$WebAccount->populate($data);
		if(isset($data["password"]))$WebAccount->setPassword($data["password"]);
		
		if(!$WebAccount->getId()){
		    /* @var $Person \Entities\Person\PersonAbstract */
		    $Person = $this->_em->find("Entities\Person\PersonAbstract", $this->_params["person_id"]);
		    if(!$Person)
			throw new Exception("Can not add web account. No Person with that Id");

		    $Person->setWebAccount($WebAccount);
		    $this->_em->persist($Person);
		}
		else $this->_em->persist($WebAccount);

		$this->_em->flush();

		$message = "Web Account saved";
		$this->_FlashMessenger->addSuccessMessage($message);

	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack(1);
	    }
	    $this->_History->goBack(1);
	}
	
	$this->view->form	    = $form;
	$this->view->WebAccount	    = $WebAccount;
    }
    
    public function rolesAction(){
	$this->view->headScript()->appendFile("/javascript/webaccount/roles.js");
	
	/* @var $WebAccount \Entities\Company\Website\Account */
	$WebAccount		    = $this->_em->find("\Entities\Company\Website\Account",$this->_params["id"]); 
	$this->view->WebAccount	    = $WebAccount;
	$this->view->Roles	    = $this->_em->getRepository("Entities\Company\Website\Account\Role")->findAll();
    }
    
    public function addroleAction(){
	$this->_helper->viewRenderer->setNoRender(true);
	$ACL = new Dataservice_Controller_Plugin_ACL();
	$ACL->preDispatch($this->_request);
	$this->_helper->layout->disableLayout();
	
	$WebAccount = $this->getEntityFromParamFields("WebAccount", array("id"));
	$Role	    = $this->_em->find("Entities\Company\Website\Account\Role", $this->_request->getParam("role_id", 0));
	
	if($WebAccount && $Role){
	    $WebAccount->addRole($Role);
	    $this->_em->persist($WebAccount);
	    $this->_em->flush();
	    $this->_FlashMessenger->addSuccessMessage("Role Added");
	}
	else{
	    $this->_FlashMessenger->addErrorMessage("Error Adding Role - WebAccount or Role Not Available");
	}
	
	$this->_History->goBack(1);
    }
    
    public function removeroleAction(){
	$this->_helper->viewRenderer->setNoRender(true);
	$ACL = new Dataservice_Controller_Plugin_ACL();
	$ACL->preDispatch($this->_request);
	$this->_helper->layout->disableLayout();
	
	$WebAccount = $this->getEntityFromParamFields("WebAccount", array("id"));
	$Role	    = $this->_em->find("Entities\Company\Website\Account\Role", $this->_request->getParam("role_id", 0));
	if($WebAccount && $Role){
	    $WebAccount->removeRole($Role->getId());
	    $this->_em->persist($WebAccount);
	    $this->_em->flush();
	    $this->_FlashMessenger->addSuccessMessage("Role Removed");
	}
	else{
	    $this->_FlashMessenger->addErrorMessage("Error Removing Role - WebAccount or Role Not Available");
	}
	
	$this->_History->goBack(1);
    }
}

