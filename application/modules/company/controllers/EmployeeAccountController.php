<?php

/**
 * 
 * @author jessie
 *
 */

class Company_EmployeeAccountController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/employee/account.js");
	parent::init();
    }
    
    public function editAction()
    {
	/* @var $Account \Entities\Company\Employee\Account */
	$Account	= $this->_getAccount();
	$safe		= !$Account->getId() || $this->getRequest()->getParam("pwd", 0) === "1" ? false : true;
	$form		= new Forms\Company\Employee\Account(array("method" => "post"), $Account, $safe);
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$data	= $this->_params["company_employee_account"];
		
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
    
    /**
     * @return Entities\Company\Employee\Account
     */
    private function _getAccount()
    {
	return $this->getEntityFromParamFields("Company\Employee\Account", array("id"));
    }
    
    private function _CheckRequiredAccountExists(Entities\Company\Employee\Account $Account)
    {
	if(!$Account->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Account");
	    $this->_History->goBack();
	}
    } 
}

