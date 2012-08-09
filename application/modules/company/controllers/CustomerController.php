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
	$this->view->headScript()->appendFile("/javascript/company/customer.js");
	parent::init();
    }
    
    public function editAction()
    {
	$Customer = $this->getEntityFromParamFields("Company/Customer", array("id"));
	
	$form = new Forms\Company\Customer(array("method" => "post"), $Customer);
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$customer_data	= $this->_params["company_customer"];
		$Employee	= $this->_em->find("Entities\Company\Location\Employee", $customer_data["employee"]);
		
		$Customer->setEmployee($Employee);
		$Customer->populate($customer_data);
		
		$this->_em->persist($Customer);
		$this->_em->flush();

		$message = "Customer '".htmlspecialchars($Customer->getFullName())."' saved";
		
		$this->_FlashMessenger->addSuccessMessage($message);
		$this->_History->goBack(1);
	    } 
	    catch (Exception $exc) 
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack(1);
	    }
	}
	
	$this->view->form	= $form;
	$this->view->Customer	= $Customer;
    }
    
    public function viewAction()
    {
	$this->view->headScript()->appendFile("/javascript/company/customer.js");
	$this->view->headScript()->appendFile("/javascript/jquery/jquery-ui.min.js");
	$this->view->headLink()->prependStylesheet('/css/jquery-ui/flick/jquery-ui.custom.css');
	
	$redirect	= false;
	
	if(isset($this->_params["id"]))
	{
	    $Customer = $this->_helper->EntityManager()->find("Entities\Customer", $this->_params["id"]);
	    if(!$Customer)$redirect = true;
	}
	else $redirect = true;
	
	if($redirect)$this->_FlashMessenger->addErrorMessage("Could not get Customer");
	
	$Company		= \Services\Company::factory()->getCurrentCompany();
	$this->view->Customer	= $Customer;
	$this->view->Locations	= $Company->getLocations();
    }
    
    public function searchAction()
    {	
	$this->view->headScript()->appendFile("/javascript/company/customer/search.js");
	$this->view->headScript()->appendFile("/javascript/jquery/jquery-ui.min.js");
	$this->view->headLink()->prependStylesheet('/css/jquery-ui/flick/jquery-ui.custom.css');
    }
    
    public function searchautocompleteAction()
    {
	$this->_helper->layout->setLayout("blank");
	$this->_helper->viewRenderer->setNoRender(true);
	
	$ACL = new Dataservice_Controller_Plugin_ACL();
	
	$ACL->preDispatch($this->_request);	
	
	$term	= $this->_autocompleteGetTerm();
	$return	= \Services\Company\Lead::factory()->getAutocompleteLeadsArrayFromTerm($term, "customer");
	
	echo json_encode($return);
    }

    private function _autocompleteGetTerm()
    {
	$term = '';
	
	if (isset($_GET['term']))$term = strtolower($_GET['term']);
	
	if (!$term)exit;
	
	return $term;
    }
}

