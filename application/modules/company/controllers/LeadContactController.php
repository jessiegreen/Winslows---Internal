<?php
class Company_LeadContactController extends Dataservice_Controller_Action
{      
    public function editcontact()
    {
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["lead_id"]))throw new Exception("Can not edit contact. No Id");
	    /* @var $Lead Entities\Company\Lead */
	    $Lead  = $em->find("Entities\Company\Lead", $this->_params["lead_id"]);
	    /* @var $Lead Entities\Contact */
	    $Contact   = $em->find("Entities\Contact", $this->_params["contact_id"]);
	    
	    if(!$Lead || !$Contact)throw new Exception("Can not edit contact. No Lead or Contact with that Id");
	    
	    $form = new Form_Person_Contact(array("method" => "post"), $Contact);
	    
	    $form->addElement(
		    "button", 
		    "cancel", 
		    array(
			"label" => "cancel", 
			"onclick" => "location='/lead/edit/id/".$this->_params["lead_id"]."'"
			)
		    );
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	    $this->_redirect('/lead/edit/id/'.$this->_params["lead_id"]);
	}
	
	if($this->_request->isPost())
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
	/* @var $Contact \Entities\Contact */
	$Contact	= $this->getEntityFromParamFields("Contact", array("id"));
	$Lead		= $this->_em->find("Entities\Company\Lead", $this->_request->getParam("lead_id", 0));
	
	if(!$Lead){
	    $this->_FlashMessenger->addErrorMessage("Can not add contact lead not sent");
	    $this->_History->goBack(1);
	}
	
	$form		= new Form_Contact($Lead, array("method" => "post"), $Contact);
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try {
		$contact_data   = $this->_params["contact"];

		$Contact->populate($contact_data);
		
		$type_data = json_decode($contact_data["type"]);
		$Contact->setType($type_data->type);
		$Contact->setTypeDetail($type_data->type_detail);
		$Contact->setPerson($this->_em->find("Entities\Person\PersonAbstract", $contact_data["person"]));

		if(!$Contact->getId()){
		   $Lead->addContact($Contact);
		   $this->_em->persist($Lead);
		}
		else{
		    $this->_em->persist($Contact);
		}
		
		$this->_em->flush();
		
		$this->_FlashMessenger->addSuccessMessage("Contact Saved");
	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    }
	    $this->_History->goBack(1);
	}
	else $form->populate($this->_params);
	    
	$this->view->form	= $form;
	$this->view->Contact	= $Contact;
    }
    
    public function editOld()
    {
	/* @var $PersonAddress \Entities\Person\Address */
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
		    /* @var $Person \Entities\Person\PersonAbstract */
		    $Person = $this->_em->find("Entities\Person\PersonAbstract", $this->_params["person_id"]);
		    if(!$Person)
			throw new Exception("Can not add address. No Person with that Id");

		    $Person->addPersonAddress($PersonAddress);
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

