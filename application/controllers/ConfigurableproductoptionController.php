<?php

/**
 * 
 * @author jessie
 *
 */

class ConfigurableproductoptionController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/configurableproductoption/configurableproductoption.js");
	parent::init();
    }
    
    public function preDispatch(){
	parent::preDispatch();
    }
    
    public function viewAction()
    {
	$ConfigurableProductOption = $this->getEntityFromParamFields("ConfigurableProductOption", array("id"));
	
	if(!$ConfigurableProductOption->getId()){
	    $this->_FlashMessenger->addErrorMessage("Could not get ConfigurableProductOption");
	    $this->_History->goBack();
	}
	
	$this->view->ConfigurableProductOption	= $ConfigurableProductOption;
    }
    
    public function viewallAction()
    {
	$ConfigurableProductOptionRepos		= $this->_em->getRepository("Entities\ConfigurableProductOption");
	$this->view->ConfigurableProductOptions	= $ConfigurableProductOptionRepos->findBy(array(), array("name" => "ASC"));
    }
    
    public function editAction()
    {
	/* @var $ConfigurableProductOption \Entities\ConfigurableProductOption */ 
	$ConfigurableProductOption	    = $this->getEntityFromParamFields("ConfigurableProductOption", array("id"));
	$configurableproductoptiongroup_id  = $this->_request->getParam("configurableproductoptiongroup_id");
	$new				    = !$ConfigurableProductOption->getId() ? true : false;
	
	if($new && $configurableproductoptiongroup_id){
	    $ConfigurableProductOptionGroup = $this->_em->find(
							    "Entities\ConfigurableProductOptionGroup", 
							    $configurableproductoptiongroup_id
							);
	    $ConfigurableProductOption->setConfigurableProductOptionGroup($ConfigurableProductOptionGroup);
	}
	
	$form = new Form_ConfigurableProductOption(array("method" => "post"), $ConfigurableProductOption);
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$data	= $this->_params["configurableproductoption"];

		$ConfigurableProductOption->populate($data);
		
		$ConfigurableProductOptionGroup = $this->_em->find(
							"Entities\ConfigurableProductOptionGroup", 
							$data["configurableproductoptiongroup_id"]
						    );
		
		if($ConfigurableProductOptionGroup){
		    $ConfigurableProductOption->setConfigurableProductOptionGroup($ConfigurableProductOptionGroup);
		    $this->_em->persist($ConfigurableProductOption);
		    $this->_em->flush();
		}
		else{
		    $this->_FlashMessenger->addErrorMessage("Could Not Get Option Group");
		    $this->_History->goBack();
		}

		$message = "Configurable Product Option '".htmlspecialchars($ConfigurableProductOption->getName())."' saved";
		$this->_FlashMessenger->addSuccessMessage($message);
		$this->_History->goBack();
	    } 
	    catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->form			= $form;
	$this->view->ConfigurableProductOption	= $ConfigurableProductOption;
    }
    
    public function deleteAction(){
	$this->_helper->viewRenderer->setNoRender(true);
	$ACL = new Dataservice_Controller_Plugin_ACL();
	$ACL->preDispatch($this->_request);
	$this->_helper->layout->disableLayout();
	
	/* @var $ConfigurableProductOption \Entities\ConfigurableProductOption */
	$ConfigurableProductOption = $this->getEntityFromParamFields("ConfigurableProductOption", array("id"));

	if($ConfigurableProductOption->getId()){
	    try {
		$this->_em->remove($ConfigurableProductOption);
		$this->_em->flush();
		
		$this->_FlashMessenger->addSuccessMessage("Configurable Product Option Deleted");
		$this->_History->goBack();
	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	else{
	    $this->_FlashMessenger->addErrorMessage("Could Not Get Configurable Product Option");
	    $this->_History->goBack();
	}
    }
}

