<?php

/**
 * 
 * @author jessie
 *
 */

class Company_DealerController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/dealer.js");
	
	parent::init();
    }
    
    public function viewAction()
    {
	$Dealer = $this->getEntityFromParamFields("Company\Dealer", array("id"));
	
	if(!$Dealer->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Dealer");
	    $this->_History->goBack();
	}
	
	$this->view->Dealer	= $Dealer;
    }
    
    public function viewAllAction()
    {
	$Dealers		    = $this->_em->getRepository("Entities\Company\Dealer")->findAll();
	$this->view->Dealers	    = $Dealers;
    }
    
    public function editAction()
    {
	$Dealer	= $this->getEntityFromParamFields("Company\Dealer", array("id"));
	$company_id	= $this->_request->getParam("company_id");
	
	if(!$Dealer->getId() && $company_id)
	{
	    $Company = $this->_em->getRepository("Entities\Company")->find($company_id);

	    if($Company)
	    {
		$Dealer->setCompany($Company);
	    }
	}
	
	$form = new Forms\Company\Dealer(array("method" => "post"), $Dealer);
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$dealer_data	= $this->_params["company_dealer"];

		$Dealer->populate($dealer_data);
		
		if($dealer_data["company_id"])
		{
		    $Company = $this->_em->getRepository("Entities\Company")->find($dealer_data["company_id"]);
		    
		    if($Company)
		    {
			$Dealer->setCompany($Company);
		    }
		}
		
		$this->_em->persist($Dealer);
		$this->_em->flush();

		$message = "Dealer '".htmlspecialchars($Dealer->getName())."' saved";
		$this->_FlashMessenger->addSuccessMessage($message);
		$this->_History->goBack();
	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->form	= $form;
	$this->view->Dealer	= $Dealer;
    }
}

