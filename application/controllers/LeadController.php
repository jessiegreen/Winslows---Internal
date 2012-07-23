<?php

/**
 * 
 * @author jessie
 *
 */

class LeadController extends Zend_Controller_Action
{
    protected $_request;
    protected $_params;
    
    public function init(){
	$this->_request	    = $this->getRequest();
	$this->_params	    = $this->_request->getParams();
    }
    
    public function addAction(){
	$form = new Form_Lead_Add;
	if($this->_request->isPost()){
	    if($form->isValid($this->_params)){
		$data		= $this->_params;
		$Lead		= new Entities\Lead;
		$person_data	= $data["person"];
		$lead_data	= $data["lead"];
		$em		= $this->_helper->EntityManager();
		$flashMessenger = $this->_helper->getHelper('FlashMessenger');
		
		$Lead->setCompany($lead_data["company"]);
		$Lead->setFirstName($person_data["first_name"]);
		$Lead->setMiddleName($person_data["middle_name"]);
		$Lead->setLastName($person_data["last_name"]);
		$Lead->setSuffix($person_data["suffix"]);
		
		$em->persist($Lead);
		$em->flush();
		
		$message = "Lead '".htmlspecialchars($Lead->getFullName())."' saved";
		$flashMessenger->addMessage(array("message" => $message, "status" =>  "success"));
		$this->_redirect('/lead/edit/id/'.$Lead->getId());
	    }
	    else $form->populate ($this->_params);
	}
	$this->view->form = $form;
    }
    
    public function viewAction(){
	$this->view->headScript()->appendFile("/javascript/lead/lead.js");
	$this->view->headScript()->appendFile("/javascript/jquery-ui.min.js");
	$this->view->headLink()->prependStylesheet('/css/jquery-ui/flick/jquery-ui.custom.css');
	
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	$redirect	= false;
	
	if(isset($this->_params["id"])){
	    $Lead = $this->_helper->EntityManager()->find("Entities\Lead", $this->_params["id"]);
	    if(!$Lead)$redirect = true;
	}
	else $redirect = true;
	if($redirect){
	    $flashMessenger->addMessage(array("message" => "Could not get Lead", "status" =>  "error"));
	}
	
	$Company	= \Services\Company::factory()->getCurrentCompany();
	$this->view->Lead	= $Lead;
	$this->view->Locations	= $Company->getLocations();
    }
    
    public function searchAction()
    {	
	$this->view->headScript()->appendFile("/javascript/lead/lead.js");
	$this->view->headScript()->appendFile("/javascript/jquery-ui.min.js");
	$this->view->headLink()->prependStylesheet('/css/jquery-ui/flick/jquery-ui.custom.css');
    }
    
    public function searchautocompleteAction()
    {
	$ACL = new Dataservice_Controller_Plugin_ACL();
	$ACL->preDispatch($this->_request);
	
	$this->_helper->layout->setLayout("blank");
	$this->_helper->viewRenderer->setNoRender(true);
	
	$term		= $this->_autocompleteGetTerm();
	$return		= \Services\Lead::factory()->getAutocompleteLeadsArrayFromTerm($term);
	echo json_encode($return);
    }

    private function _autocompleteGetTerm(){
	$term = '';
	if (isset($_GET['term'])) {
	    $term = strtolower($_GET['term']);
	}
	if (!$term) {
	    exit;
	}
	return $term;
    }
    
    public function addaddressAction(){
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["id"]))throw new Exception("Can not add address. No Id");
	    /* @var $Lead Entities\Lead */
	    $Lead	= $em->find("Entities\Lead", $this->_params["id"]);
	    
	    if(!$Lead)throw new Exception("Can not add address. No Lead with that Id");
	    
	    $form = new Form_PersonAddress(array("method" => "post"));
	    
	    $form->addElement(
		    "button", 
		    "cancel", 
		    array(
			"label" => "cancel", 
			"onclick" => "location='/lead/edit/id/".$this->_params["id"]."'"
			)
		    );
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	    $this->_redirect('/lead/edit/id/'.$this->_params["id"]);
	}
	
	if($this->_request->isPost())
	{
	    if($form->isValid($this->_params))
	    {
		try {
		    $address_params = $this->_params["address"];
		    $PersonAddress = new \Entities\PersonAddress();
		    $PersonAddress->setName($address_params['name']);
		    $PersonAddress->setAddress1($address_params['address_1']);
		    $PersonAddress->setAddress2($address_params['address_2']);
		    $PersonAddress->setCity($address_params['city']);
		    $PersonAddress->setState($address_params['state']);
		    $PersonAddress->setZip1($address_params['zip_1']);
		    $PersonAddress->setZip2($address_params['zip_2']);
		    $Lead->addPersonAddress($PersonAddress);
		    
		    $em->persist($Lead);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Lead Address '".$PersonAddress->getName()."' for '".
						$Lead->getFullName()."' Added", 
				'status' => 'success'
				)
			    );
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/lead/edit/id/'.$this->_params["id"]);
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form	= $form;
	$this->view->Lead	= $Lead;
    }
    
    public function addphoneAction(){
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["id"]))throw new Exception("Can not add phone number. No Id");
	    /* @var $Lead Entities\Lead */
	    $Lead	= $em->find("Entities\Lead", $this->_params["id"]);
	    
	    if(!$Lead)throw new Exception("Can not add phone number. No Lead with that Id");
	    
	    $form = new Form_Person_PhoneNumber(array("method" => "post"));
	    
	    $form->addElement(
		    "button", 
		    "cancel", 
		    array(
			"label" => "cancel", 
			"onclick" => "location='/lead/edit/id/".$this->_params["id"]."'"
			)
		    );
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	    $this->_redirect('/lead/edit/id/'.$this->_params["id"]);
	}
	
	if($this->_request->isPost())
	{
	    if($form->isValid($this->_params))
	    {
		try {
		    $phone_data = $this->_params["phonenumber"];
		    $PhoneNumber = new \Entities\PhoneNumber();
		    $PhoneNumber->setType($phone_data["type"]);
		    $PhoneNumber->setAreaCode($phone_data["phone_number"]["area"]);
		    $PhoneNumber->setNum1($phone_data["phone_number"]["prefix"]);
		    $PhoneNumber->setNum2($phone_data["phone_number"]["line"]);
		    $PhoneNumber->setExtension($phone_data["extension"]);
		    $Lead->addPhoneNumber($PhoneNumber);
		    
		    $em->persist($Lead);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Lead Phone Number '".$PhoneNumber->getType()."' for '".
						$Lead->getFullName()."' Added", 
				'status' => 'success'
				)
			    );
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/lead/edit/id/'.$this->_params["id"]);
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form	= $form;
	$this->view->Lead	= $Lead;
    }
    
    public function editaddressAction(){
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["lead_id"]))throw new Exception("Can not edit address. No Id");
	    /* @var $Lead Entities\Lead */
	    $Lead	    = $em->find("Entities\Lead", $this->_params["lead_id"]);
	    $PersonAddress  = $em->find("Entities\Personaddress", $this->_params["address_id"]);
	    
	    if(!$Lead || !$PersonAddress)throw new Exception("Can not edit address. No Lead or Address with that Id");
	    
	    $form = new Form_PersonAddress_PersonAddress(array("method" => "post"), $PersonAddress);
	    
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
		    $address_params = $this->_params["address"];
		    $PersonAddress->setName($address_params['name']);
		    $PersonAddress->setAddress1($address_params['address_1']);
		    $PersonAddress->setAddress2($address_params['address_2']);
		    $PersonAddress->setCity($address_params['city']);
		    $PersonAddress->setState($address_params['state']);
		    $PersonAddress->setZip1($address_params['zip_1']);
		    $PersonAddress->setZip2($address_params['zip_2']);
		    
		    $em->persist($PersonAddress);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Lead Address '".$PersonAddress->getName()."' for '".
						$Lead->getFullName()."' Edited", 
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
    
    public function editphoneAction(){
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["lead_id"]))throw new Exception("Can not edit phone. No Id");
	    /* @var $Lead Entities\Lead */
	    $Lead	    = $em->find("Entities\Lead", $this->_params["lead_id"]);
	    $PhoneNumber    = $em->find("Entities\PhoneNumber", $this->_params["phonenumber_id"]);
	    
	    if(!$Lead || !$PhoneNumber)throw new Exception("Can not edit phone. No Lead or PhoneNumber with that Id");
	    
	    $form = new Form_Person_PhoneNumber(array("method" => "post"), $PhoneNumber);
	    
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
		    $phone_data = $this->_params["phonenumber"];
		    
		    $PhoneNumber->setType($phone_data["type"]);
		    $PhoneNumber->setAreaCode($phone_data["phone_number"]["area"]);
		    $PhoneNumber->setNum1($phone_data["phone_number"]["prefix"]);
		    $PhoneNumber->setNum2($phone_data["phone_number"]["line"]);
		    $PhoneNumber->setExtension($phone_data["extension"]);
		    
		    $em->persist($PhoneNumber);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Lead Phone Number '".$PhoneNumber->getType()."' for '".
						$Lead->getFullName()."' Edited", 
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
    
    public function editemailAction(){
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["lead_id"]))throw new Exception("Can not edit email. No Id");
	    /* @var $Lead Entities\Lead */
	    $Lead	    = $em->find("Entities\Lead", $this->_params["lead_id"]);
	    $EmailAddress   = $em->find("Entities\Emailaddress", $this->_params["emailaddress_id"]);
	    
	    if(!$Lead || !$EmailAddress)throw new Exception("Can not edit email. No Lead or Email with that Id");
	    
	    $form = new Form_Person_Emailaddress(array("method" => "post"), $EmailAddress);
	    
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
		    $email_data = $this->_params["emailaddress"];
		    
		    $EmailAddress->setType($email_data["type"]);
		    $EmailAddress->setAddress($email_data["address"]);
		    
		    $em->persist($EmailAddress);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Lead Email Address '".$EmailAddress->getType()."' for '".
						$Lead->getFullName()."' Edited", 
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
    
    public function addemailAction(){
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["id"]))throw new Exception("Can not add email address. No Id");
	    /* @var $Lead Entities\Lead */
	    $Lead	= $em->find("Entities\Lead", $this->_params["id"]);
	    
	    if(!$Lead)throw new Exception("Can not add email address. No Lead with that Id");
	    
	    $form = new Form_Person_Emailaddress(array("method" => "post"));
	    
	    $form->addElement(
		    "button", 
		    "cancel", 
		    array(
			"label" => "cancel", 
			"onclick" => "location='/lead/edit/id/".$this->_params["id"]."'"
			)
		    );
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	    $this->_redirect('/lead/edit/id/'.$this->_params["id"]);
	}
	
	if($this->_request->isPost())
	{
	    if($form->isValid($this->_params))
	    {
		try {
		    $email_data = $this->_params["emailaddress"];
		    $Emailaddress = new \Entities\Emailaddress();
		    $Emailaddress->setType($email_data["type"]);
		    $Emailaddress->setAddress($email_data["address"]);
		    $Lead->addEmailAddress($Emailaddress);
		    
		    $em->persist($Lead);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Lead Email Address '".$Emailaddress->getType()."' for '".
						$Lead->getFullName()."' Added", 
				'status' => 'success'
				)
			    );
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/lead/edit/id/'.$this->_params["id"]);
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form	= $form;
	$this->view->Lead	= $Lead;
    }
    
    public function editcontactAction(){
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["lead_id"]))throw new Exception("Can not edit contact. No Id");
	    /* @var $Lead Entities\Lead */
	    $Lead  = $em->find("Entities\Lead", $this->_params["lead_id"]);
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
    
    public function addcontactAction(){
	$Person		= Services\Auth::factory()->getIdentityWebAccount()->getPerson();
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["id"]))throw new Exception("Can not add contact. No Id");
	    /* @var $Lead \Entities\Lead */
	    $em->flush();
	    $Lead	= $em->find("Entities\Lead", $this->_params["id"]);
	    
	    if(!$Lead)throw new Exception("Can not add contact. No Lead with that Id");
	    
	    $Contact	    = new \Entities\Contact();
	    
	    if(isset($this->_params["type"]) && key_exists($this->_params["type"], $Contact->getTypeOptions())){
		$Contact->setType($this->_params["type"]);
		if(isset($this->_params["type_id"])){
		    switch ($this->_params["type"]) {
			case "phone":
			    $PhoneNumber = $this->_helper->EntityManager()->find("Entities\PhoneNumber", $this->_params["type_id"]);
			    if($PhoneNumber)$Contact->setTypeDetail ($PhoneNumber->getNumberDisplay());
			    break;
			case "location":
			    $Location = $this->_helper->EntityManager()->find("Entities\Location", $this->_params["type_id"]);
			    if($Location)$Contact->setTypeDetail ($Location->getName());
			    break;
			case "email":
			    $Email = $this->_helper->EntityManager()->find("Entities\Emailaddress", $this->_params["type_id"]);
			    if($Email)$Contact->setTypeDetail ($Email->getAddress());
			    break;
		    }
		}
	    }
	    
	    $form = new Form_Person_Contact(array("method" => "post"), $Contact);
	    
	    $form->addElement(
		    "button", 
		    "cancel", 
		    array(
			"label" => "cancel", 
			"onclick" => "location='/lead/edit/id/".$this->_params["id"]."'"
			)
		    );
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	    $this->_redirect('/lead/edit/id/'.$this->_params["id"]);
	}
	
	if($this->_request->isPost())
	{
	    if($form->isValid($this->_params))
	    {
		try {
		    $contact_data   = $this->_params["contact"];
		    $Contact	    = new \Entities\Contact();
		    
		    $Contact->setType($contact_data["type"]);
		    $Contact->setTypeDetail($contact_data["type_detail"]);
		    $Contact->setNote($contact_data["note"]);
		    $Contact->setResult($contact_data["result"]);
		    $Contact->setPerson($Person);
		    
		    $Lead->addContact($Contact);
		    
		    $em->persist($Lead);
		    $em->flush();
		    
		    $flashMessenger->addMessage(
			    array(
				'message' => "Contact '".
						$Contact->getCreated()->format("F j, Y, g:i a").
						"' added to '".$Contact->getLead()->getFullName()."'", 
				'status' => 'success'
				)
			    );
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/lead/edit/id/'.$this->_params["id"]);
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form	= $form;
	$this->view->Lead	= $Lead;
    }
}

