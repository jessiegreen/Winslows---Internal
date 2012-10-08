<?php

/**
 * 
 * @author jessie
 *
 */

class Company_RtoProviderApplicationController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/rto-provider/application.js");
	
	parent::init();
    }
    
    public function editAction()
    {
	/* @var $Application \Entities\Company\RtoProvider\Application */
	$Application	    = $this->getEntityFromParamFields("Company\RtoProvider\Application", array("id"));
	$lead_id	    = $this->_request->getParam("lead_id");
	$rto_provider_id    = $this->_request->getParam("rto_provider_id");
	
	if(!$Application->getId())
	{
	    if(!$lead_id)
	    {
		$this->_FlashMessenger->addErrorMessage ("Lead Id not sent.");
		$this->_History->goBack();
	    }
	    else
	    {
		$Lead = $this->_em->getRepository("Entities\Company\Lead")->find($lead_id);
		
		if(!$Lead)
		{
		    $this->_FlashMessenger->addErrorMessage ("Could not get Lead.");
		    $this->_History->goBack();
		}
		else $Application->setLead($Lead);
	    }
	    
	    if(!$rto_provider_id)
	    {
		$this->_FlashMessenger->addErrorMessage ("Rto Provider Id not sent.");
		$this->_History->goBack();
	    }
	    else
	    {
		$RtoProvider = $this->_em->getRepository("Entities\Company\RtoProvider")->find($rto_provider_id);
		
		if(!$RtoProvider)
		{
		    $this->_FlashMessenger->addErrorMessage ("Could not get Lead.");
		    $this->_History->goBack();
		}
		else $Application->setRtoProvider ($RtoProvider);
	    }
	}
	else $RtoProvider = $Application->getRtoProvider ();
	
	$form = new Forms\Company\RtoProvider\Application($Application, array("method" => "post"));
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data = $this->_params["company_rto_provider_application"];

		$Application->populate($data);
		
		$this->_em->persist($Application);
		$this->_em->flush();

		$message = "Application '".htmlspecialchars($RtoProvider->getName())."' saved";
		$this->_FlashMessenger->addSuccessMessage($message);
		$this->_History->goBack();
	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->form	    = $form;
	$this->view->RtoProvider    = $RtoProvider;
    }
}

