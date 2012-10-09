<?php

class Company_RtoProviderFeeRangeValueController extends Dataservice_Controller_Action
{    
    public function editAction()
    {
	$Value	    = $this->getEntityFromParamFields("Company\RtoProvider\Fee\Range\Value", array("id"));
	$range_id   = $this->_request->getParam("range_id");
	
	if(!$Value->getId() && $range_id)
	{
	    $Range = $this->_em->getRepository("Entities\Company\RtoProvider\Fee\Range")->find($range_id);
	    
	    if($Range)
	    {
		$Value->setRange($Range);
	    }
	}
	
	$form = new Forms\Company\RtoProvider\Fee\Range\Value($Value, array("method" => "post"));
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$value_data = $this->_params["company_rto_provider_fee_range_value"];

		if($value_data["range_id"])
		{
		    $Range = $this->_em->getRepository("Entities\Company\RtoProvider\Fee\Range")->find($value_data["range_id"]);
	    
		    if($Range)
		    {
			$Value->setRange($Range);
		    }
		}
		
		$Value->populate($value_data);
		
		$this->_em->persist($Value);
		$this->_em->flush();

		$message = "Range value saved";
		
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
	$this->view->Value	= $Value;
    }
}

