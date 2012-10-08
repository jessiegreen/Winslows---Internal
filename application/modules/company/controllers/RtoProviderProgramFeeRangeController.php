<?php

/**
 * 
 * @author jessie
 *
 */

class Company_RtoProviderProgramFeeRangeController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/rto-provider/program/fee/range.js");
	
	parent::init();
    }
    
    public function editAction()
    {
	$Range	    = $this->getEntityFromParamFields("Company\RtoProvider\Program\Fee\Range", array("id"));
	$program_id = $this->_request->getParam("program_id");
	
	if(!$Range->getId() && $program_id)
	{
	    $Program = $this->_em->getRepository("Entities\Company\RtoProvider\Program")->find($program_id);

	    if($Program)
	    {
		$Range->setProgram($Program);
	    }
	}
	
	$form = new Forms\Company\RtoProvider\Program\Fee\Range($Range, array("method" => "post"));
	
	$form->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$range_data = $this->_params["company_rto_provider_program_fee_range"];

		$Range->populate($range_data);
		
		if($range_data["program_id"])
		{
		    $Program = $this->_em->getRepository("Entities\Company\RtoProvider\Program")->find($range_data["program_id"]);
		    
		    if($Program)
		    {
			$Range->setProgram($Program);
		    }
		}
		
		$this->_em->persist($Range);
		$this->_em->flush();

		$message = "Range '".htmlspecialchars($Program->getName())."' saved";
		
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
	$Range = $this->getEntityFromParamFields("Company\RtoProvider\Program\Fee\Range", array("id"));
	
	if(!$Range->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Range");
	    $this->_History->goBack();
	}
	
	$this->view->Range = $Range;
    }
}

