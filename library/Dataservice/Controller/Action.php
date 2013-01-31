<?php
/**
 * Description of Action
 *
 * @author jgreen
 */
class Dataservice_Controller_Action extends Zend_Controller_Action
{
    /**
     * @var \Entities\Company\Website
     */
    protected $_Website;
    
    /**
     * @var \Dataservice_Doctrine_Entity 
     */
    protected $_Entity = null;
    
    /**
     * @var type 
     */
    protected $_EntityClass;
    
    /**
     *  @var \Doctrine\ORM\EntityManager $_em 
     */
    protected $_em;
    
    /**
     * @var Dataservice_Controller_Action_Helper_FlashMessenger $_FlashMessenger 
     */
    public $_FlashMessenger;
    
    /**
     * @var Dataservice_Controller_Action_Helper_History $_History 
     */
    public $_History;
    
    public function init()
    {
	$this->_setEntityManager();
	$this->_setEntity();
	$this->_setFlashMessenger();
	$this->_setHistory();
	$this->_setCurrentWebsite();
	$this->_loadJsAndCss();	
	$this->_setViewProperties();
	
	parent::init();
    }
    
    public function isPostAndValid(Zend_Form $form, $params = null)
    {
	if($params === null)
	{
	    $params = $this->_getAllParams();
	}
	
	if($this->getRequest()->isPost())
	{
	    if($form->isValid($params))return true;
	    else
	    {
		$form->populate($params);
		
		return false;
	    }
	}
	return false;
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
    }
    
    protected function _entityRequired()
    {
	if(!$this->_Entity || !$this->_Entity->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get required entity");
	    $this->_History->goBack();
	}
    }
    
    protected function _deleteEntity()
    {
	$this->_entityRequired();
	
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
    
    protected function _setCurrentWebsite()
    {
	$this->_Website	= Services\Company\Website::factory()->getCurrentWebsite();
    }
    
    protected function _setHistory()
    {
	$this->_History = new Dataservice_Controller_Action_Helper_History();
    }
    
    protected function _setFlashMessenger()
    {
	$this->_FlashMessenger = new Dataservice_Controller_Action_Helper_FlashMessenger;
    }
    
    protected function _setEntityManager()
    {
	$this->_em = $this->_helper->EntityManager();
    }
    
    protected function _loadJsAndCss()
    {
	$css_string = "/css/".$this->getRequest()->getModuleName().
			"/".$this->getRequest()->getControllerName().
			"/".$this->getRequest()->getActionName().".css";
	
	if(file_exists(PUBLIC_PATH.$css_string))
	    $this->view->headLink()->appendStylesheet(BASE_URL.$css_string);
	
	$js_string = "/javascript/".$this->getRequest()->getModuleName().
			"/".str_ireplace("-", "/", $this->getRequest()->getControllerName()).
			"/".$this->getRequest()->getActionName().".js";
	
	if(file_exists(PUBLIC_PATH.$js_string))
	    $this->view->headScript()->appendFile(BASE_URL.$js_string);
    }
    
    protected function _setViewProperties()
    {
	$Entity = $this->_Entity;
	
	if($Entity)
	{
	    $EntityClassName		    = $Entity->getClassName();
	    $this->view->$EntityClassName   = $Entity;
	}
    }
    
    /**
     * @return \Entities\Company\Website
     */
    public function getWebsite()
    {
	return $this->_Website;
    }
}