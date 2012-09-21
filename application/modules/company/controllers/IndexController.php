<?php
class Company_IndexController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company.js");
	parent::init();
    }
    
    public function indexAction()
    {
	
    }
    
    public function viewAction()
    {
	$Company = $this->getEntityFromParamFields("Company", array("id"));
	
	if(!$Company->getId()){
	    $this->_FlashMessenger->addErrorMessage("Could not get Company");
	    $this->_History->goBack();
	}
	
	$this->view->Company	= $Company;
    }
    
    public function viewallAction()
    {
	$CompanyRepos		= $this->_em->getRepository("Entities\Company");
	$this->view->Companys	= $CompanyRepos->findAll();
    }
    
    public function editAction()
    {
	$Company = $this->getEntityFromParamFields("Company", array("id"));
	
	$form = new Forms\Company(array("method" => "post"), $Company);
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$company_data	= $this->_params["company"];

		$Company->populate($company_data);
		$this->_em->persist($Company);
		$this->_em->flush();

		$message = "Company '".htmlspecialchars($Company->getName())."' saved";
		$this->_FlashMessenger->addSuccessMessage($message);
		$this->_History->goBack();
	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->form	= $form;
	$this->view->Company	= $Company;
    }
}

