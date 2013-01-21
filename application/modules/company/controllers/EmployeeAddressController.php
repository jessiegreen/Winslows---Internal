<?php

/**
 * 
 * @author jessie
 *
 */

class Company_EmployeeAddressController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	/* @var $Address \Entities\Person\Address */
	$Address	= $this->getEntityFromParamFields("Person\Address", array("id"));
	$form		= new Forms\Person\Address(array("method" => "post"), $Address);
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["person_address"];
		
		$Address->populate($data);
		
		if(!$Address->getId())
		{
		    /* @var $Employee \Entities\Company\Employee */
		    $Person = $this->_em->find("Entities\Company\Employee", $this->_params["employee_id"]);
		    
		    if(!$Person)
			throw new Exception("Can not add address. No Employee with that Id");

		    $Person->addAddress($Address);
		    $this->_em->persist($Person);
		}
		else $this->_em->persist($Address);

		$this->_em->flush();

		$message = "Employee Address saved";
		
		$this->_FlashMessenger->addSuccessMessage($message);

	    }
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	    $this->_History->goBack();
	}
	
	$this->view->form	    = $form;
	$this->view->PersonAddress  = $Address;
    }
}

