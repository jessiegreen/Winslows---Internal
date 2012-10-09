<?php

/**
 * 
 * @author jessie
 *
 */

class Company_RtoProviderFeeRangeController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/rto-provider/fee/range.js");
	
	parent::init();
    }
    
    public function editAction()
    {
	$Range		    = $this->getEntityFromParamFields("Company\RtoProvider\Fee\Range", array("id"));
	$rto_provider_id    = $this->_request->getParam("rto_provider_id");
	
	if(!$Range->getId() && $rto_provider_id)
	{
	    $RtoProvider = $this->_em->getRepository("Entities\Company\RtoProvider")->find($rto_provider_id);
	    
	    if($RtoProvider)
	    {
		$Range->setRtoProvider($RtoProvider);
	    }
	}
	
	$form = new Forms\Company\RtoProvider\Fee\Range($Range, array("method" => "post"));
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$range_data = $this->_params["company_rto_provider_fee_range"];

		if($range_data["rto_provider_id"])
		{
		    $RtoProvider = $this->_em->getRepository("Entities\Company\RtoProvider")->find($range_data["rto_provider_id"]);
	    
		    if($RtoProvider)
		    {
			$Range->setRtoProvider($RtoProvider);
		    }
		}
		
		$Range->populate($range_data);
		
		$this->_em->persist($Range);
		$this->_em->flush();

		$message = "Range fee saved";
		
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
	$this->view->Range	= $Range;
    }
    
    public function viewAction()
    {
	$Range = $this->getEntityFromParamFields("Company\RtoProvider\Fee\Range", array("id"));
	
	if(!$Range->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Range");
	    $this->_History->goBack();
	}
	
	$this->view->Range = $Range;
    }
}

