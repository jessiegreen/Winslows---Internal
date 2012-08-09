<?php

/**
 * 
 * @author jessie
 *
 */

class Company_SupplierProductConfigurableOptionController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/configurableproductoptiongroup/configurableproductoptiongroup.js");
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
		$data	= $this->_params["configurableproductoptiongroup"];

		$ConfigurableProductOptionGroup->populate($data);
		
		$configurableproduct_id = $this->_request->getParam("configurableproduct_id");
		
		if(!$ConfigurableProductOptionGroup->getId() && $configurableproduct_id){
		    $ConfigurableProduct = $this->_em->find("Entities\ConfigurableProduct", $configurableproduct_id);
		    if($ConfigurableProduct){
			$ConfigurableProduct->addConfigurableProductOptionGroup($ConfigurableProductOptionGroup);
			$this->_em->persist($ConfigurableProduct);
			$this->_em->flush();
		    }
		}
		else{
		    $this->_em->persist($ConfigurableProductOptionGroup);
		    $this->_em->flush();
		}

		$message = "Configurable Product Option Group '".htmlspecialchars($ConfigurableProductOptionGroup->getName())."' saved";
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
    
    public function deleteAction(){
	$this->_helper->viewRenderer->setNoRender(true);
	$ACL = new Dataservice_Controller_Plugin_ACL();
	$ACL->preDispatch($this->_request);
	$this->_helper->layout->disableLayout();
	
	/* @var $ConfigurableProductOptionGroup \Entities\ConfigurableProductOptionGroup */
	$ConfigurableProductOptionGroup = $this->getEntityFromParamFields("ConfigurableProductOptionGroup", array("id"));

	if($ConfigurableProductOptionGroup->getId()){
	    try {
		$this->_em->remove($ConfigurableProductOptionGroup);
		$this->_em->flush();
		$this->_FlashMessenger->addSuccessMessage("Configurable Product Option Group Deleted");
		$this->_History->goBack();
	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	else{
	    $this->_FlashMessenger->addErrorMessage("Could Not Get Configurable Product Option Group");
	    $this->_History->goBack();
	}
    }
}

