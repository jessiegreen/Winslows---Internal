<?php
class Company_EmployeeController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Employee";
	
	parent::init();
    }
    
    public function viewAction()
    {
	$this->_entityRequired();
    }
    
    public function editAction()
    {
	$company_id = $this->getRequest()->getParam("company_id", null);
	
	if(!$this->_Entity->getId())
	{
	    if($company_id)
	    {
		$Company = $this->_em->getRepository("Entities\Company")->findOneById($company_id);
	    
		if($Company)
		{
		    $this->_Entity->setCompany($Company);
		}
	    }
	}	
	
	$form = $this->_Entity->getEditForm()->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$employee_data	= $this->_getParam("company_employee", array());
		$Location	= $this->_em->find("Entities\Company\Location",$employee_data["location_id"]);
		$Company	= $this->_em->find("Entities\Company",$employee_data["company_id"]);

		if($Location)
		    $this->_Entity->setLocation($Location);
		else throw new Exception("Can not edit employee. No Location with that Id");
		
		if($Company)
		    $this->_Entity->setCompany($Company);
		else throw new Exception("Can not edit employee. No Company with that Id");

		$this->_Entity->populate($employee_data);
		
		$this->_em->persist($this->_Entity);
		$this->_em->flush();

		$message = "Employee '".htmlspecialchars($this->_Entity->getFullName())."' saved";
		
		$this->_FlashMessenger->addSuccessMessage($message);
	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    }
	    
	    $this->_History->goBack();
	}
	
	$this->view->form	= $form;
	$this->view->Employee	= $this->_Entity;
    }
    
    public function deleteAction()
    {
	$this->_deleteEntity();
    }
    
    public function clockPunchAction()
    {
	$this->_entityRequired();
	
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

