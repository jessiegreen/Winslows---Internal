<?php
class Company_EmployeeController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Employee";
	
	parent::init();
    }
    
    public function clockPunchAction()
    {
	$this->_requireEntity();
	
	try
	{
	    $this->_Entity->clockInOut();
	    $this->_FlashMessenger->addSuccessMessage($this->_Entity->isClockedIn() ? "Clocked In" : "Clocked Out");
	} 
	catch (Exception $exc)
	{
	    $this->_FlashMessenger->addErrorMessage($exc->getMessage());
	}
	
	$this->_History->goBack();
	
	exit;
    }
    
    public function getLeadsLabelValueJsonAction()
    {
	$term		    = $this->_getParam("term");
	
	$Employee	    = $this->_Website->getCurrentUserAccount(Zend_Auth::getInstance())->getPerson();
	$leads		    = $Employee->getAllAllowedLeadsAutocomplete($term);

	echo $this->_helper->json($leads);

	exit;
    }
}

