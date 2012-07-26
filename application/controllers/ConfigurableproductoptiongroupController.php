<?php

/**
 * 
 * @author jessie
 *
 */

class ConfigurableproductoptiongroupController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/company.js");
	parent::init();
    }
    
    public function viewAction()
    {
	$ConfigurableProductOptionGroup = $this->getEntityFromParamFields("ConfigurableProductOptionGroup", array("id"));
	
	if(!$ConfigurableProductOptionGroup->getId()){
	    $this->_FlashMessenger->addErrorMessage("Could not get ConfigurableProductOptionGroup");
	    $this->_History->goBack();
	}
	
	$this->view->ConfigurableProductOptionGroup	= $ConfigurableProductOptionGroup;
    }
    
    public function viewallAction()
    {
	$ConfigurableProductOptionGroupRepos		= $this->_em->getRepository("Entities\ConfigurableProductOptionGroup");
	$this->view->ConfigurableProductOptionGroups	= $ConfigurableProductOptionGroupRepos->findAll();
    }
    
    public function editAction()
    {
	$ConfigurableProductOptionGroup = $this->getEntityFromParamFields("ConfigurableProductOptionGroup", array("id"));
	
	$form = new Form_ConfigurableProductOptionGroup(array("method" => "post"), $ConfigurableProductOptionGroup);
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$company_data	= $this->_params["company"];

		$ConfigurableProductOptionGroup->populate($company_data);
		$this->_em->persist($ConfigurableProductOptionGroup);
		$this->_em->flush();

		$message = "ConfigurableProductOptionGroup '".htmlspecialchars($ConfigurableProductOptionGroup->getName())."' saved";
		$this->_FlashMessenger->addSuccessMessage($message);
		$this->_History->goBack();
	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->form	= $form;
	$this->view->ConfigurableProductOptionGroup	= $ConfigurableProductOptionGroup;
    }
}

