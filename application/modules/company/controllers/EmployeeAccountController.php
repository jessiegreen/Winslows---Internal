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
        $employee_id    = $this->_request->getParam("employee_id");
	$safe		= !$Account->getId() || $this->getRequest()->getParam("pwd", 0) === "1" ? false : true;
        
        if(!$Account->getId() && $employee_id)
        {
            $Employee = $this->_em->getRepository("Entities\Company\Employee")->find($employee_id);
            
            if($Employee)
            {
                $Account->setEmployee($Employee);
            }
        }
        
	$form = new Forms\Company\Employee\Account(array("method" => "post"), $Account, $safe);
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
        {
	    try 
	    {
		$data = $this->_params["company_employee_account"];
		
		$Account->populate($data);
		
		if(isset($data["password"]))$Account->setPassword($data["password"]);
		
		if($data["employee_id"])
		{
		    $Employee = $this->_em->find("Entities\Person\PersonAbstract", $data["employee_id"]);
		    
		    if(!$Employee)
			throw new Exception("Can not add web account. No Employee with that Id");

		    $Account->setEmployee($Employee);
		}
                
                if($data["website_id"])
		{
		    $Website = $this->_em->find("Entities\Company\Website", $data["website_id"]);
		    
		    if(!$Website)
			throw new Exception("Can not add web account. No Website with that Id");

		    $Account->setWebsite($Website);
		}
		
                $this->_em->persist($Account);
		$this->_em->flush();

		$message = "Web Account saved";
		$this->_FlashMessenger->addSuccessMessage($message);
	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    }
            
	    $this->_History->goBack();
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

