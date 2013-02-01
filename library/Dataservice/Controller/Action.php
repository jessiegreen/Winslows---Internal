<?php
class Dataservice_Controller_Action extends Zend_Controller_Action
{
    /**
     * @var \Entities\Company\Website
     */
    protected $_Website;
    
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
	$this->_setFlashMessenger();
	$this->_setHistory();
	$this->_setCurrentWebsite();
	$this->_loadJsAndCss();	
	
	parent::init();
    }
    
    public function postDispatch()
    {
	$this->_setViewProperties();
	
	parent::postDispatch();
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
	
    }
    
    /**
     * @return \Entities\Company\Website
     */
    public function getWebsite()
    {
	return $this->_Website;
    }
}