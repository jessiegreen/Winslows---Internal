<?php

/**
 * 
 * @author jessie
 *
 */

class Company_SupplierProductConfigurableOptionParameterValueController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/configurableproductoptionvalue/configurableproductoptionvalue.js");
	parent::init();
    }
    
    public function viewallAction()
    {
	$ConfigurableProductOptionValueRepos		= $this->_em->getRepository("Entities\ConfigurableProductOptionValue");
	$this->view->ConfigurableProductOptionsValues	= $ConfigurableProductOptionValueRepos->findBy(array(), array("ConfigurableProductOption_id" => "ASC", "name" => "ASC"));
    }
    
    public function editAction()
    {
	/* @var $ConfigurableProductOptionValue \Entities\ConfigurableProductOptionValue */
	$ConfigurableProductOptionValue = $this->getEntityFromParamFields("ConfigurableProductOptionValue", array("id"));
	$configurableproductoption_id	= $this->_request->getParam("configurableproductoption_id");
	$new				= !$ConfigurableProductOptionValue->getId() ? true : false;
	
	if($new && $configurableproductoption_id){
	    $ConfigurableProductOption	= $this->_em->find(
							    "Entities\ConfigurableProductOption", 
							    $configurableproductoption_id
							);
	    if($ConfigurableProductOption){
		$ConfigurableProductOptionValue->setConfigurableProductOption($ConfigurableProductOption);
	    }
	    else{
		$this->_FlashMessenger->addErrorMessage("Could Not Get Option Group");
		$this->_History->goBack();
	    }
	}
	
	$form = new Form_ConfigurableProductOptionValue(array("method" => "post"), $ConfigurableProductOptionValue);
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form)){
	    try 
	    {
		$data	= $this->_params["configurableproductoptionvalue"];

		$ConfigurableProductOptionValue->populate($data);
		
		$ConfigurableProductOption = $this->_em->find(
							"Entities\ConfigurableProductOption", 
							$data["configurableproductoption_id"]
						    );
		
		if($ConfigurableProductOption){
		    $ConfigurableProductOptionValue->setConfigurableProductOption($ConfigurableProductOption);
		    $this->_em->persist($ConfigurableProductOptionValue);
		    $this->_em->flush();
		}
		else{
		    $this->_FlashMessenger->addErrorMessage("Could Not Get Option Group");
		    $this->_History->goBack();
		}

		$message = "Configurable Product Option Value '".htmlspecialchars($ConfigurableProductOptionValue->getName())."' saved";
		$this->_FlashMessenger->addSuccessMessage($message);
		$this->_History->goBack();
	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->form			    = $form;
	$this->view->ConfigurableProductOptionValue = $ConfigurableProductOptionValue;
    }
    
    public function deleteAction()
    {
	$this->_helper->viewRenderer->setNoRender(true);
	$ACL = new Dataservice_Controller_Plugin_ACL();
	$ACL->preDispatch($this->_request);
	$this->_helper->layout->disableLayout();
	
	/* @var $ConfigurableProductOptionValue \Entities\ConfigurableProductOptionValue */
	$ConfigurableProductOptionValue = $this->getEntityFromParamFields("ConfigurableProductOptionValue", array("id"));
	if($ConfigurableProductOptionValue){
	    try {
		$this->_em->remove($ConfigurableProductOptionValue);
		$this->_em->flush();
		$this->_FlashMessenger->addSuccessMessage("Configurable Product Option Value Deleted");
		$this->_History->goBack();
	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	else{
	    $this->_FlashMessenger->addErrorMessage("Could Not Get Configurable Product Option Value");
	    $this->_History->goBack();
	}
    }
}

