<?php
class Company_LeadContactController extends Dataservice_Controller_Action
{      
    public function editcontact()
    {
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try
	{
	    if(!isset($this->_params["lead_id"]))throw new Exception("Can not edit contact. No Id");
	    
	    /* @var $Lead Entities\Company\Lead */
	    $Lead	= $em->find("Entities\Company\Lead", $this->_params["lead_id"]);
	    /* @var $Lead \Entities\Company\Lead\Contact */
	    $Contact	= $em->find("Entities\Company\Lead\Contact", $this->_params["contact_id"]);
	    
	    if(!$Lead || !$Contact)throw new Exception("Can not edit contact. No Lead or Contact with that Id");
	    
	    $form = new Forms\Company\Lead\Contact(array("method" => "post"), $Contact);
	    
	    $form->addCancelButton($this->_History->getPreviousUrl());
	}
	catch (Exception $exc)
	{
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	    $this->_redirect('/lead/edit/id/'.$this->_params["lead_id"]);
	}
	
	if($this->getRequest()->isPost())
	{
	    if($form->isValid($this->_params))
	    {
		try {
		    $contact_data = $this->_params["contact"];
		    
		    $Contact->setType($contact_data["type"]);
		    $Contact->setTypeDetail($contact_data["type_detail"]);
		    $Contact->setNote($contact_data["note"]);
		    $Contact->setResult($contact_data["result"]);
		    
		    $em->persist($Contact);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Lead Contact on '".
						$Contact->getCreated()->format("F j, Y, g:i a").
						"' for '".$Lead->getFullName()."' Edited", 
				'status' => 'success'
				)
			    );
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/lead/edit/id/'.$this->_params["lead_id"]);
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form	= $form;
	$this->view->Lead	= $Lead;
    }
    
    public function editAction()
    {
	/* @var $Contact \Entities\Company\Lead\Contact */
	$Contact    = $this->getEntityFromParamFields("Company\Lead\Contact", array("id"));
	$lead_id    = $this->getRequest()->getParam("lead_id");
	
	if(!$Contact->getId())
	{
	    if($lead_id)
	    {
		$Lead = $this->_em->getRepository("Entities\Company\Lead")->find($lead_id);
		
		if($Lead)
		{
		    $Contact->setLead($Lead);
		}
		else
		{
		    $this->_FlashMessenger->addErrorMessage("Can not get Lead");
		    $this->_History->goBack();
		}
	    }
	    else
	    {
		$this->_FlashMessenger->addErrorMessage("Can not add contact lead not sent");
		$this->_History->goBack();
	    }
	}
	
	$form = new Forms\Company\Lead\Contact(array("method" => "post"), $Contact);
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try
	    {
		$contact_data   = $this->_params["company_lead_contact"];

		$Contact->populate($contact_data);
		
		$type_data = json_decode($contact_data["type"]);
		
		$Contact->setType($type_data->type);
		$Contact->setTypeDetail($type_data->type_detail);
		
		if($contact_data["employee_id"])
		{
		    $Employee = $this->_em->getRepository("Entities\Company\Employee")->find($contact_data["employee_id"]);
		    
		    if($Employee)
			$Contact->setEmployee ($Employee);
		}

		$this->_em->persist($Contact);
		$this->_em->flush();
		
		$this->_FlashMessenger->addSuccessMessage("Contact Saved");
	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    }
	    
	    $this->_History->goBack();
	}
	else $form->populate($this->_params);
	    
	$this->view->form	= $form;
	$this->view->Contact	= $Contact;
    }
    
    public function editOld()
    {
	/* @var $PersonAddress \Entities\Company\Person\Address */
	$PersonAddress	= $this->getEntityFromParamFields("PersonAddress", array("id"));
	$form		= new Form_PersonAddress(array("method" => "post"), $PersonAddress);
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$data	= $this->_params["personaddress"];
		
		$PersonAddress->populate($data);
		
		if(!$PersonAddress->getId()){
		    /* @var $Person \Entities\Company\Person\PersonAbstract */
		    $Person = $this->_em->find("Entities\Company\Person\PersonAbstract", $this->_params["person_id"]);
		    if(!$Person)
			throw new Exception("Can not add address. No Person with that Id");

		    $Person->addAddress($PersonAddress);
		    $this->_em->persist($Person);
		}
		else $this->_em->persist($PersonAddress);

		$this->_em->flush();

		$message = "Person Address saved";
		$this->_FlashMessenger->addSuccessMessage($message);

	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack(1);
	    }
	    $this->_History->goBack(1);
	}
	
	$this->view->form	    = $form;
	$this->view->PersonAddress  = $PersonAddress;
    }
}

