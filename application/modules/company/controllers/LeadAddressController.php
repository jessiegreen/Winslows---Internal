<?php

/**
 * 
 * @author jessie
 *
 */

class Company_LeadAddressController extends Dataservice_Controller_Action
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
		    /* @var $Person \Entities\Person\PersonAbstract */
		    $Person = $this->_em->find("Entities\Person\PersonAbstract", $this->_params["person_id"]);
		    
		    if(!$Person)
			throw new Exception("Can not add address. No Person with that Id");

		    $Person->addAddress($Address);
		    $this->_em->persist($Person);
		}
		else $this->_em->persist($Address);

		$this->_em->flush();

		$message = "Person Address saved";
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
	$this->view->PersonAddress  = $Address;
    }
}

