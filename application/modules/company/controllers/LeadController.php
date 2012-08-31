<?php

class Company_LeadController extends Dataservice_Controller_Action
{
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/lead.js");
	parent::init();
    }
    
    public function editAction()
    {
	$Lead = $this->getEntityFromParamFields("Lead", array("id"));
	
	$form = new Form_Lead(array("method" => "post"), $Lead);
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$lead_data	= $this->_params["lead"];
		$Employee	= $this->_em->find("Entities\Company\Employee", $lead_data["employee"]);
		
		$Lead->setEmployee($Employee);
		$Lead->populate($lead_data);
		
		$this->_em->persist($Lead);
		$this->_em->flush();

		$message = "Lead '".htmlspecialchars($Lead->getFullName())."' saved";
		$this->_FlashMessenger->addSuccessMessage($message);
		
		$this->_redirect("/lead/view/id/".$Lead->getId());
		
	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack(1);
	    }
	}
	
	$this->view->form	= $form;
	$this->view->Lead	= $Lead;
    }
    
    public function viewAction()
    {
	$this->view->headScript()->appendFile("/javascript/jquery/jquery-ui.min.js");
	$this->view->headLink()->prependStylesheet('/css/jquery-ui/flick/jquery-ui.custom.css');
	
	$redirect	= false;
	
	if(isset($this->_params["id"]))
	{
	    $Lead = $this->_helper->EntityManager()->find("Entities\Company\Lead", $this->_params["id"]);
	    
	    if(!$Lead)$redirect = true;
	}
	else $redirect = true;
	
	if($redirect)$this->_FlashMessenger->addErrorMessage("Could not get Lead");
	
	$Company		= \Services\Company::factory()->getCurrentCompany();
	$this->view->Lead	= $Lead;
	$this->view->Locations	= $Company->getLocations();
    }
    
    public function searchAction()
    {	
	$this->view->headScript()->appendFile("/javascript/company/lead/search.js");
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
	$return		= \Services\Company\Lead::factory()->getAutocompleteLeadsArrayFromTerm($term);
	echo json_encode($return);
    }

    private function _autocompleteGetTerm()
    {
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

