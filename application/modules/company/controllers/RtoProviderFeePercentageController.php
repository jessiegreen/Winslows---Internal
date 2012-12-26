<?php

/**
 * 
 * @author jessie
 *
 */

class Company_RtoProviderFeePercentageController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	$Percentage		    = $this->getEntityFromParamFields("Company\RtoProvider\Fee\Percentage", array("id"));
	$rto_provider_id    = $this->getRequest()->getParam("rto_provider_id");
	
	if(!$Percentage->getId() && $rto_provider_id)
	{
	    $RtoProvider = $this->_em->getRepository("Entities\Company\RtoProvider")->find($rto_provider_id);
	    
	    if($RtoProvider)
	    {
		$Percentage->setRtoProvider($RtoProvider);
	    }
	}
	
	$form = new Forms\Company\RtoProvider\Fee\Percentage($Percentage, array("method" => "post"));
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$percentage_data = $this->_params["company_rto_provider_fee_percentage"];

		if($percentage_data["rto_provider_id"])
		{
		    $RtoProvider = $this->_em->getRepository("Entities\Company\RtoProvider")->find($percentage_data["rto_provider_id"]);
	    
		    if($RtoProvider)
		    {
			$Percentage->setRtoProvider($RtoProvider);
		    }
		}
		
		$Percentage->populate($percentage_data);
		
		$this->_em->persist($Percentage);
		$this->_em->flush();

		$message = "Percentage fee saved";
		
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
	$this->view->Percentage	= $Percentage;
    }
    
    public function viewAction()
    {
	$Percentage = $this->getEntityFromParamFields("Company\RtoProvider\Fee\Percentage", array("id"));
	
	if(!$Percentage->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Percentage");
	    $this->_History->goBack();
	}
	
	$this->view->Percentage = $Percentage;
    }
}

