<?php
class Dataservice_Controller_Crud_Action extends Dataservice_Controller_Action 
{
    /**
     * @var \Dataservice_Doctrine_Entity 
     */
    protected $_Entity = null;
    
    /**
     * @var string 
     */
    protected $_EntityClass;
    
    public function init()
    {
	parent::init();
	
	$this->_setEntity();
	
	$this->view->headTitle()->append($this->_Entity->getClassName()." >> ".
		Dataservice\Inflector::humanize($this->getRequest()->getActionName(), "All"));
    }
    
    protected function _CheckRequiredEntityExists(\Dataservice_Doctrine_Entity $Entity)
    {
	if(!$Entity->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get ".$Entity->getClassName());
	    $this->_History->goBack();
	}
    } 
    
    protected function _setEntity()
    {
	$entity_id  = $this->_getParam("id");
	
	if($entity_id)
	{
	    $this->_Entity = $this->_em->find($this->_EntityClass, $entity_id);
	    
	    if(!$this->_Entity)
		$this->_Entity = new $this->_EntityClass();
	}
	else
	{
	    $this->_Entity = new $this->_EntityClass();
	}
    }
    
    protected function _requireEntity()
    {
	$message = "Could not get required entity";
	
	if(!$this->_Entity || !$this->_Entity->getId())
	{
	    if($this->getRequest()->isXMLHttpRequest())
		throw new \Exception($message);
	    else
	    {
		$this->_FlashMessenger->addErrorMessage();
		$this->_History->goBack();
	    }
	}
    }
    
    protected function _deleteEntity()
    {
	$this->_requireEntity();
	
	try 
	{
	    $this->_em->remove($this->_Entity);
	    $this->_em->flush();
	    $this->_FlashMessenger->addSuccessMessage("Deleted ".$this->_Entity->getClassName());
	} 
	catch (Exception $exc) 
	{
	    $this->_FlashMessenger->addErrorMessage("Error deleting ".$this->_Entity->getClassName().": ". $exc->getMessage());
	}

	$this->_History->goBack();
    }
    
    protected function _setViewProperties()
    {
	parent::_setViewProperties();
	
	$Entity = $this->_Entity;
	
	if($Entity)
	{
	    $EntityClassName		    = $Entity->getClassName();
	    $this->view->$EntityClassName   = $Entity;
	    $this->view->Entity		    = $Entity;
	}
    } 
    
    public function viewAction()
    {
	$this->_requireEntity();
    }
    
    public function editAction()
    {
	$this->_Entity->populate($this->getRequest()->getParams());	
	
	$form = $this->_Entity->getEditForm()->addCancelButton($this->_History->getPreviousUrl());
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data = $this->_getParam($this->_Entity->getEditSubform()->getElementsBelongTo(), array());
	
		$this->_Entity->populate($data);
		
		$this->_em->persist($this->_Entity);
		$this->_em->flush();
		
		$message = $this->_Entity->getClassName()." saved";
		
		$this->_FlashMessenger->addSuccessMessage($message);
	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    }
	    
	    $this->_History->goBack();
	}
	
	$this->view->form = $form;
    }
    
    public function deleteAction()
    {
	$this->_deleteEntity();
    }
}