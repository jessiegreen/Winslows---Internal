<?php

/**
 * 
 * @author jessie
 *
 */

class Company_CustomerController extends Dataservice_Controller_Action
{
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/customer/customer.js");
	parent::init();
    }
    
    public function editAction()
    {
	$Customer = $this->getEntityFromParamFields("Customer", array("id"));
	
	$form = new Form_Customer(array("method" => "post"), $Customer);
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$customer_data	= $this->_params["customer"];
		$Employee	= $this->_em->find("Entities\Employee", $customer_data["employee"]);
		
		$Customer->setEmployee($Employee);
		$Customer->populate($customer_data);
		
		$this->_em->persist($Customer);
		$this->_em->flush();

		$message = "Customer '".htmlspecialchars($Customer->getFullName())."' saved";
		$this->_FlashMessenger->addSuccessMessage($message);
		$this->_History->goBack(1);
	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack(1);
	    }
	}
	
	$this->view->form	= $form;
	$this->view->Customer	= $Customer;
    }
    
    public function viewAction(){
	$this->view->headScript()->appendFile("/javascript/customer/customer.js");
	$this->view->headScript()->appendFile("/javascript/jquery/jquery-ui.min.js");
	$this->view->headLink()->prependStylesheet('/css/jquery-ui/flick/jquery-ui.custom.css');
	
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	$redirect	= false;
	
	if(isset($this->_params["id"])){
	    $Customer = $this->_helper->EntityManager()->find("Entities\Customer", $this->_params["id"]);
	    if(!$Customer)$redirect = true;
	}
	else $redirect = true;
	if($redirect){
	    $flashMessenger->addMessage(array("message" => "Could not get Customer", "status" =>  "error"));
	}
	
	$Company	= \Services\Company::factory()->getCurrentCompany();
	$this->view->Customer	= $Customer;
	$this->view->Locations	= $Company->getLocations();
    }
    
    public function searchAction()
    {	
	$this->view->headScript()->appendFile("/javascript/customer/search.js");
	$this->view->headScript()->appendFile("/javascript/jquery/jquery-ui.min.js");
	$this->view->headLink()->prependStylesheet('/css/jquery-ui/flick/jquery-ui.custom.css');
    }
    
    public function searchautocompleteAction()
    {
	$ACL = new Dataservice_Controller_Plugin_ACL();
	$ACL->preDispatch($this->_request);
	
	$this->_helper->layout->setLayout("blank");
	$this->_helper->viewRenderer->setNoRender(true);
	
	$term		= $this->_autocompleteGetTerm();
	$return		= \Services\Lead::factory()->getAutocompleteLeadsArrayFromTerm($term, "customer");
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
}

